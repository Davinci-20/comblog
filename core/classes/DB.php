<?php
//query builder test1
class DB
{

    private static $dbh = null;
    private static $res, $data, $count, $sql;

    public function __construct()
    {
        self::$dbh = new PDO("mysql:host=localhost;dbname=blog_project", 'root', 'password');

    }

    public function query($param = [])
    {

        self::$res = self::$dbh->prepare(self::$sql);
        self::$res->execute($param);

        return $this;

    }

    public function get()
    {
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_ASSOC);
        return self::$data;
    }

    public function getOne()
    {
        $this->query();
        self::$data = self::$res->fetch(PDO::FETCH_ASSOC);
        return self::$data;
    }

    public function rowCount()
    {
        $this->query();
        self::$count = self::$res->rowCount();
        return self::$count;
    }

//query builder test2
    public static function table($table)
    {
        $sql = "select * from $table";
        self::$sql = $sql;
        $db = new DB();
        // $db->query();
        return $db;
    }

    public function orderBy($name, $value)
    {
        self::$sql .= " order by $name $value";

        return $this;
    }

    public function where($col, $operator, $value = '')
    {

        if (func_num_args() == 2) {
            self::$sql .= " where $col='$operator'";
        } else {
            self::$sql .= " where $col $operator '$value'";
        }

        return $this;
    }

    public function andwhere($col, $operator, $value = '')
    {

        if (func_num_args() == 2) {
            self::$sql .= " and $col='$operator'";
        } else {
            self::$sql .= " and $col $operator '$value'";
        }

        return $this;

    }

    public function orwhere($col, $operator, $value = '')
    {

        if (func_num_args() == 2) {
            self::$sql .= " or $col='$operator'";
        } else {
            self::$sql .= " or $col $operator '$value'";
        }

        return $this;

    }

    public static function create($table, $data)
    {
        //print_r(implode('&nbsp',array_keys($data)));
        //print_r(array_values($data));
        //die();
        $db = new DB();
        $str_col = implode(',', array_keys($data));

        $v = "";
        $x = 1;
        foreach ($data as $d) {
            $v .= "?";
            if ($x < count($data)) {
                $v .= ',';
                $x++;
            }

        }

        $sql = "insert into $table($str_col) values($v)";
        self::$sql = $sql;
        $values = array_values($data);
        $db->query($values);
        $id = self::$dbh->lastinsertid();
        return DB::table($table)->where('id', $id)->getOne();

    }

    public static function update($table, $data, $id)
    {
        $db = new DB();
        //   $sql="update $table set";
        //$str_col=implode(',',array_keys($data));
        $value = "";
        $x = 1;
        foreach ($data as $key => $val) {
            $value .= "$key=?";
            if ($x < count($data)) {
                $value .= ',';
                $x++;

            }

        }

        $sql .= "update $table set $value where id=$id";
        self::$sql = $sql;
        $values = array_values($data);
        $db->query($values);
        return DB::table($table)->where('id', $id)->getOne();
    }

    public static function delete($table, $id)
    {
        $db = new DB();
        $sql = "delete from $table where id=$id";
        self::$sql = $sql;
        $db->query();
        return true;

    }

    public static function raw($sql)
    {
        $db = new DB();
        self::$sql = $sql;
        return $db;
    }

    public function paginate($pageNum, $append = '')
    {
        if (isset($_GET['page'])) {
            $pageno = $_GET['page'];
        } else {
            $pageno = $_GET['page'] = 1;
        }

        if (isset($_GET['page']) and $_GET['page'] < 1) {
            $pageno = 1;
        }
        //0,5 start with 0 and 5 count (1-1)*5
        //5,5 start wiith 5 and 5 count (2-1)*5
        //10,5 start wiith 10 and 5 count (3-1)*5

        //get total count
        $this->query();
        $count = self::$res->rowCount();

        $index = ($pageno - 1) * $pageNum;
        //select * from user limit
        self::$sql .= " limit $index,$pageNum";
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);

        $prev_page = ($pageno - 1);
        $next_page = ($pageno + 1);
        $prev = "?page=$prev_page& $append";
        $next = "?page=$next_page& $append";

        $data = [
            'data' => self::$data,
            'total' => $count,
            'prev_page' => $prev,
            'next_page' => $next,
        ];
        return $data;

    }
}

//$d=new DB();
//$user=$d->query("select * from user")->get();
//$r= $d->query("select * from user")->get();
// echo "<pre>";
// print_r($user);

// $user = DB::table('user')->orderBy('id', desc)->get();
// echo "<pre>";
// print_r($user);
// $user=DB::table('info')->where('id',1)->orwhere('location','taungoo')->andwhere('name','like','k%')->get();

// echo "<pre>";
// var_dump($user);

//----insert----

// $user=DB::create('user',[
//     'Name'=>'Min Aye',
//     'Email'=>'minaye@gmail.com',
//     'Password'=>'minaye123',
// ]);
// print_r($user);

//----update----

// $user=DB::update('user',[
//     'Name'=>'Bella',
//     'Email'=>'bela1@gmail.com',
//     'Password'=>'bela123',
// ],9);

// print_r($user);

//--- Delete ---

// $user=DB::delete('user',19);

// //  print_r($user);

// if($user){
//     echo "Deleted Data";
// }

// $user=DB::table('user')->where('Name','like','%a%')->paginate(3);
//$user=DB::raw('select * from user')->paginate(3);

// echo "<pre>";
// var_dump($user);

// <h1 style="text-align:center">Your Data</h1>

// <hr>
//     <?php

//     foreach($user['data'] as $d){
//         echo $d->Name."<br>";
//     }

//
// <hr>

// <a href="<?php echo $user['prev_page'] ">Prev</a>
// <a href="<?php echo $user['next_page']>">Next</a>
