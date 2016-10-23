<?php

use Illuminate\Database\Seeder;

class CalculateValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [
                'name'     => 'Sugar Cost Saving',
                'alias'    => 'sugar',
                'value'    => 500
            ],
            [
                'name'     => 'Rice Cost Saving',
                'alias'    => 'rice',
                'value'    => 500
            ],
            [
                'name'     => 'Oil Cost Saving',
                'alias'    => 'oil',
                'value'    => 500
            ],
            [
                'name'     => 'Transportation Cost',
                'alias'    => 'transport',
                'value'    => 1500
            ]
        ];

        foreach ($values as $value){
            \App\CalculateValue::create($value);
        }
    }
}
