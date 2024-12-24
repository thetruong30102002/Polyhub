<?php

namespace Modules\ShowingRelease\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Carbon\Carbon;
use Modules\Movie\Entities\Movie;

class CreateShowingReleaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:rooms,id',
            'time_release' => 'required|date_format:H:i',
            'date_release' => 'required|date_format:Y-m-d|after_or_equal:today',
        ];
    }

    /**
     * Add additional validation rules after the base rules have been applied.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $movieId = $this->input('movie_id');
            $roomId = $this->input('room_id');
            $dateRelease = $this->input('date_release');
            $timeRelease = $this->input('time_release');
            
            if (!$dateRelease || !$timeRelease) {
                return;
            }
            // Lấy thông tin phim từ movie_id
            $movie = Movie::find($movieId);
            
            if (!$movie) {
                $validator->errors()->add('movie_id', 'The selected movie does not exist.');
                return;
            }

            // Lấy thời gian phát hành từ đầu vào và chuyển về múi giờ Asia/Ho_Chi_Minh
            $timeReleaseDateTime = Carbon::createFromFormat('Y-m-d H:i', $dateRelease . ' ' . $timeRelease, 'Asia/Ho_Chi_Minh');
            
            // Tính toán thời gian tối thiểu (hiện tại + 6 giờ)
            $minReleaseTime = Carbon::now('Asia/Ho_Chi_Minh')->addHours(6);
    
            // Kiểm tra nếu thời gian phát hành trước thời gian tối thiểu
            if ($timeReleaseDateTime->lessThan($minReleaseTime)) {
                $validator->errors()->add('time_release', 'Time release must be at least 6 hours later than the current time.');
            }
        
            // Kiểm tra xem đã có lịch chiếu nào khác trong phòng vào ngày và giờ đó chưa
            $existingRelease = ShowingRelease::where('room_id', $roomId)
                ->whereDate('date_release', $dateRelease)
                ->whereTime('time_release', $timeRelease)
                ->first();
        
            if ($existingRelease) {
                $validator->errors()->add('time_release', 'Showing Release already exists in this room on the selected date and time.');
            }

            // Kiểm tra premiere_date của phim
            $premiereDate = $movie->premiere_date;
            if ($premiereDate && Carbon::parse($premiereDate)->greaterThan(Carbon::parse($dateRelease))) {
                $validator->errors()->add('date_release', 'The movie premiere date is in the future. Showing release date must be on or after the movie premiere date.');
            }
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
