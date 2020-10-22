<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class System extends Model
{
    //软删除
    use  SoftDelete;




}