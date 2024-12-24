<?php
namespace Modules\Voucher\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class VoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Voucher\Entities\Voucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['Fixed', 'Percent']);

        $amount = $this->generateAmount($type);

        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addMonth()->format('Y-m-d');

        return [
           'code' => 'VOUCHER_' . date('Y') . '_' . $this->faker->randomNumber(3),
            'type' => $type,
            'amount' => $amount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'usage_limit' => $this->faker->numberBetween(1, 20),
            'used' => 0,
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }

    /**
     * Generate amount based on type.
     *
     * @param string $type
     * @return int
     */
    private function generateAmount($type)
    {
        if ($type === 'Fixed') {
            return $this->generateEvenNumber(10000);
        }

        if ($type === 'Percent') {
            return $this->faker->numberBetween(1, 70);
        }

        return null; // Trả về null nếu type không hợp lệ
    }

    /**
     * Generate an even number greater than or equal to $min.
     *
     * @param int $min
     * @return int
     */
    private function generateEvenNumber($min)
    {
        // Tạo số chẵn lớn hơn hoặc bằng $min
        $number = $this->faker->numberBetween($min, 100000); // 100000 có thể được thay đổi tùy theo nhu cầu
        return $number % 10000 === 0 ? $number : $number + (10000 - ($number % 10000));
    }
}

