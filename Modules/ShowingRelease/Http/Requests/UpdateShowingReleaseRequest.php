<?php
namespace Modules\ShowingRelease\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;

class UpdateShowingReleaseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:rooms,id',
            'time_release' => 'required|date_format:H:i',
            'date_release' => 'required|date_format:Y-m-d|after_or_equal:today',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $showingRelease = ShowingRelease::find($this->route('showingrelease'));
    
            // Kiểm tra nếu không có thay đổi nào
            if ($this->input('movie_id') == $showingRelease->movie_id &&
                $this->input('room_id') == $showingRelease->room_id &&
                $this->input('date_release') == $showingRelease->date_release &&
                $this->input('time_release') == $showingRelease->time_release) {
                return;
            }
            $roomId = $this->input('room_id');
            $dateRelease = $this->input('date_release');
            $timeRelease = $this->input('time_release');
            // Kiểm tra nếu thời gian phát hành ít nhất là 6 giờ so với thời gian hiện tại
            if ($dateRelease && $timeRelease) {
                $releaseDateTime = Carbon::createFromFormat('Y-m-d H:i', $dateRelease . ' ' . $timeRelease, 'Asia/Ho_Chi_Minh');
                $minReleaseTime = Carbon::now('Asia/Ho_Chi_Minh')->addHours(6);
                if ($releaseDateTime->lessThan($minReleaseTime)) {
                    $validator->errors()->add('time_release', 'Time release must be at least 6 hours greater than the current time.');
                }
            }
            // Kiểm tra xem đã có suất chiếu nào khác cùng thời điểm và phòng chưa
            if ($roomId && $dateRelease && $timeRelease) {
                // Kiểm tra nếu phòng đã thay đổi
                if ($showingRelease->room_id == $roomId) {
                    // Kiểm tra trùng lặp trong cùng phòng
                    $existingRelease = ShowingRelease::where('room_id', $roomId)
                        ->whereDate('date_release', $dateRelease)
                        ->whereTime('time_release', $timeRelease)
                        ->where('id', '<>', $showingRelease->id)
                        ->first();
            
                    if ($existingRelease) {
                        $validator->errors()->add('time_release', 'Showing Release already exists in this room on the selected date and time.');
                    }
                }
            }
        });
    }

    public function authorize()
    {
        return true;
    }
}




