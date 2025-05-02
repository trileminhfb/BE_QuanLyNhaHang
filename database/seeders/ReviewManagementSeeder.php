<?php

namespace Database\Seeders;

use App\Models\ReviewManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewManagementSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'id_rate' => 1,
                'id_user' => 1,
                'comment' => 'Cảm ơn bạn đã đánh giá, mình đồng tình với nhận xét của bạn!',
            ],
            [
                'id_rate' => 1,
                'id_user' => 2,
                'comment' => 'Cảm ơn bạn đã góp ý.',
            ],
            [
                'id_rate' => 2,
                'id_user' => 3,
                'comment' => 'Nhà hàng ghi nhận ý kiến của bạn ạ',
            ],
            [
                'id_rate' => 3,
                'id_user' => 2,
                'comment' => 'CBọn mình sẽ điều chỉnh lại ạ.',
            ],
            [
                'id_rate' => 4,
                'id_user' => 4,
                'comment' => 'Cảm ơn bạn.',
            ],
        ];

        foreach ($reviews as $review) {
            ReviewManagement::create($review);
        }
    }
}
