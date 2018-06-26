<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                'name'=>'后盾网',
                'title'=>'国内最好的PHP培训机构',
                'url'=>'http://houdunwang.com',
                'no_order'=>1
            ],
            [
                'name'=>'后盾论坛',
                'title'=>'后盾网，人人做后盾',
                'url'=>'http://bbs.houdunwang.com',
                'no_order'=>2
            ],
        ];
        DB::table('links')->insert($data);
    }
}
