<?php


namespace app\index\controller;


use think\Controller;
use think\Db;

class Baobiao extends Controller
{

    public function index()
    {

        //本地经纬度  lng：115.81545148941039     lat:28.662623384469203
        //查询数据表中经纬度
        $LngandLat = "point(lng,lat)";
        $nowLngandLat = "point(115.81545148941,28.6626233844692)";
        $lng1 = 115.81545148941;
        $lat1 = 28.662623384469;
        //  $query1 = "select * from sb_user_geo order by ACOS(SIN(('.$city_lat.' * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(('.$city_lat.' * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(('.$city_lng.' * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380  asc  limit 30";
        // $sql = 'SELECT * FROM store WHERE lat > 28.662623384469-1 AND lat < 28.662623384469+1 AND lng > 115.81545148941-1 AND lng < 115.81545148941+1 ORDER BY ACOS(SIN((28.662623384469 * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS((28.662623384469 * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS((115.81545148941* 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380 ASC LIMIT 10';
        $sql = 'SELECT * FROM store WHERE lat >"' . $lat1 . '"-1 AND lat < "' . $lat1 . '"+1 AND lng > "' . $lng1 . '"-1 AND lng < "' . $lng1 . '"+1 ORDER BY ACOS(SIN(("' . $lat1 . '" * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(("' . $lat1 . '" * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(("' . $lng1 . '"* 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380 ASC LIMIT 10';
        // $query = "select name,province,city,area,lng,lat,round((st_distance($LngandLat,$nowLngandLat)/0.0111)*1000) AS distance from store HAVING distance<20000 ORDER BY distance";
        //  $Nearbystores = Db::connect("db_config1")->query('select name,province,city,area,lng,lat,(st_distance(point(lng,lat),point(115.815451489410,28.6626233844692))/0.0111) AS distances from store HAVING distances<15 ORDER BY distances');
        //  $Nearbystores = Db::connect("db_config1")->query('select name,province,city,area,lng,lat,TRUNCATE((st_distance(point(lng,lat),point(115.815451489410,28.6626233844692))/0.0111),2) AS distance from store HAVING distance<15 ORDER BY distance');
        /* $Nearbystores = Db::connect("db_config1")->table("store")->where(['status'=>-1])->select();*/
        $Nearbystores = Db::connect('db_config1')->query($sql);
        $distance = array();
        for ($i = 0; $i < count($Nearbystores); $i++) {
            $lng2 = $Nearbystores[$i]['lng'];
            $lat2 = $Nearbystores[$i]['lat'];
            $distance[] = $this->_distance($lng1, $lat1, $lng2, $lat2);
        }

        $viewData = [
            'storesInfo' => $Nearbystores,
            'distance' => $distance
        ];
        $this->assign($viewData);
        return $this->fetch();

    }

    /**
     *求两个已知经纬度之间的距离,单位为千米
     * @param lng1,lng2 经度
     * @param lat1,lat2 纬度
     * @return float 距离，单位千米
     **/
    private function _distance($lng1, $lat1, $lng2, $lat2)
    {
        //将角度转为弧度
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;//两纬度之差,纬度<90
        $b = $radLng1 - $radLng2;//两经度之差纬度<180
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;
        return round($s, 2);
    }

    //查询附近门店
    public function nearbyme()
    {

        //得到当前位置的经纬度   lng,lat
        $lng1 = 115.81545148941;
        $lat1 = 28.662623384469;

        //编写sql语句   查询距离当前位置经纬度差值大于小于1的门店
        $sql = 'SELECT * FROM store WHERE lat >"' . $lat1 . '"-1 AND lat < "' . $lat1 . '"+1 AND lng > "' . $lng1 . '"-1 AND lng < "' . $lng1 . '"+1 AND status=1 ORDER BY ACOS(SIN(("' . $lat1 . '" * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS(("' . $lat1 . '" * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS(("' . $lng1 . '"* 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380 ASC LIMIT 10';
        //查询出最近的前十个门店
        $Nearbystores = Db::connect('db_config1')->query($sql);
        //定义一个数组用于接收与这十个门店的距离
        $distance = array();
        //循环添加这十个门店的距离放入数组
        for ($i = 0; $i < count($Nearbystores); $i++) {
            $lng2 = $Nearbystores[$i]['lng'];
            $lat2 = $Nearbystores[$i]['lat'];
            //调用经纬度计算出实际距离 km
            $distance[] = $this->_distance($lng1, $lat1, $lng2, $lat2);
        }
        //将数据存入返回视图
        $viewData = [
            'storesInfo' => $Nearbystores,
            'distance' => $distance
        ];
        $this->assign($viewData);
        return $this->fetch();


    }


    public function getfiles()
    {
        $arr = array(['a'=>'456', 'b'=>5, 'c'=>'sadd', 'd'=>5, 'e'=>'asdasd', 'f'=>'asd', 'g'=>'asfa']);


        //return $this->fetch();
    }

    public function dirfiles()
    {

        //通过路径获取路径下的所有文件信息
        //接受数据并保证安全
        $dir = $_GET['dir'] ?? '';

        //判断路径有效性：无效返回
        if (!is_dir($dir)) {
            //无效返回
            echo '路径无效';
            //跳转
            header('Refresh:3;url=/error.html');
            //终止代码
            exit;
        }
        //取出数据  驱虎当前文件夹中的数据
        /* $files = scandir($dir);
         foreach ($files as $file) {
             echo $file;
             echo '</br>';
         }*/
        //输出所有目录下的文件名
        //return json_encode($files,JSON_UNESCAPED_UNICODE);

        /*var_dump($files);
        if (!$files) {
            //路径无效
            echo '路径无效';
            exit;
        }*/

        //定义一个保存数据的数组  设置为静态的函数能够跨域共享数据
        static $output = array();

        //取出当前文件夹中的数据
        $files = scandir($dir);
        //return json_encode($files,JSON_UNESCAPED_UNICODE);
        foreach ($files as $file) {
            //判断是文件还是文件夹
            $tmp_file = $dir . '/' . $file;
            if (is_dir($tmp_file)) {
                //存储数据
                $output[] = array(
                    'filename' => $file,
                    'directory' => $dir,
                    'is_dir' => true,

                );
                /* //递归点  排除.和..
                 if ($file == '.' || $file == '..') continue;*/

            } else {
                $output[] = array(
                    'filename' => $file,
                    'directory' => $dir,
                    'is_dir' => false,
                );
            }

        }

        var_dump($output[1]['filename']);
        return json_encode($output, JSON_UNESCAPED_UNICODE);

    }


}