<?php
//设置命名空间
namespace houdunwang\model;

//调用方法因为需要直接调用它
use Exception;
use PDO;

//创建一个类
class Base
{
    //创建一个静态方法，设置为null
    private static $pdo = null;
    //操作数据表
    protected $table;
    //sql语句where条件
    protected $where;
    //指定查询的字段
    protected $field = '';
    //创建属性，因为排序的时候需要用到
    protected $order = '';

    //创建方法
    public function __construct($class)
    {
        $info = explode('\\', $class);
        $this->table = strtolower($info[2]);
//        p($this->table);
        //1.连接数据库
        //if判断，如果数据库属性$pdo已经连接过数据库了就不用重复连接了
        if (is_null(self::$pdo)) {
            $this->connect();
        }
    }

    /**
     * 连接数据库
     */
    private function connect()
    {
        try {
            $dsn = c('database.driver') . ":host=" . c('database.host') . ";dbname=" .
                c('database.dbname');
            $user = c('database.user');
            $password = c('database.password');
            self::$pdo = new PDO($dsn, $user, $password);
            //字符集
            self::$pdo->query('set names ' . c('database.charset'));
            //设置错误属性
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 根据主键获取数据库单一一条数据
     * @param $pk
     * @return mixed
     */
    public function find($pk)
    {
        //p($this->table);
        //获取查询数据表的主键
        $priKey = $this->getPriKey();
        $this->field = $this->field ?: '*';
        //$sql = "select * from student where id=1";
        $sql = "select {$this->field} from {$this->table} where {$priKey}={$pk}";
        $res = $this->q($sql);

        return current($res);
    }

    /**
     * 查询单一一条数据
     * @return mixed
     */
    public function first()
    {
        //$sql = "select * from student where sname='赵虎'";
        $this->field = $this->field ?: '*';

        $sql = "select {$this->field} from {$this->table} {$this->where} {$this->order}";
        $data = $this->q($sql);

        //p($data);
        return current($data);
    }

    /**
     * 查找指定列的字段
     * @param $field
     * @return $this
     */
    public function field($field)
    {
        //p ( $field );//sname,sex
        $this->field = $field;

        return $this;
    }

    /**
     * sql语句中where条件
     * @param $where
     * @return $this
     */
    public function where($where)
    {
        //p($where);//age>30
        //"where age>30"
        $this->where = 'where ' . $where;

        return $this;
    }

    /**
     * 获取数据表中所有数据
     * @return mixed
     */
    public function getAll()
    {
        //$this->field  = $this->field ? $this->field : '*';
        $this->field = $this->field ?: '*';
        //$sql = "select * from student";
        $sql = "select {$this->field} from {$this -> table}  {$this->where} {$this->order}";

//        p($sql);die;
        return $this->q($sql);
    }

    /**
     * 获取数据表中主键的名称
     * @return mixed
     */
    public function getPriKey()
    {
        $sql = "desc {$this->table}";
        $res = $this->q($sql);
        //p($res);//这里一定要打印看数据
        foreach ($res as $k => $v) {
            if ($v['Key'] == 'PRI') {
                $priKey = $v['Field'];
                break;
            }
        }

        return $priKey;
    }

    /**
     * 更新数据
     * @param $data
     * @return bool|mixed
     */
    public function update($data)
    {
        //如果没有where条件不允许更新
        if (!$this->where) {
            return false;
        }
        $set = '';
        foreach ($data as $k => $v) {
            if (is_int($v)) {
                $set .= $k . '=' . $v . ',';
            } else {
                $set .= $k . '=' . "'$v'" . ',';
            }
        }
        $set = rtrim($set, ',');
        //p($set);die;
        //sql = "update student set sname='',age=19,sex='男' where id=1";
        $sql = "update {$this->table} set {$set} {$this->where}";
        return $this->e($sql);
    }

    public function delete()
    {
        //如果没有where条件不允许更新
        if (!$this->where) {
            return false;
        }
        //$sql = "delete from student where id=1";
        $sql = "delete from {$this->table} {$this->where}";
        return $this->e($sql);
    }

    /**
     * 数据表写入数据
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        //p($data);die;
        $field = '';
        $value = '';
        foreach ($data as $k => $v) {
            $field .= $k . ',';
            if (is_int($v)) {
                $value .= $v . ',';
            } else {
                $value .= "'$v'" . ',';
            }
        }
        $field = rtrim($field, ',');
        //p($field);die;
        $value = rtrim($value, ',');
        //p($value);die;
        //$sql = "insert into student (age,sname,sex,cid) values (1,'超人','男',1)";
        $sql = "insert into {$this->table} ({$field}) values ({$value})";
        //p($sql);die;
        return $this->e($sql);
    }

    public function order($order)
    {
//        p ($order);
//        将字段和order by一起进行连接,要注意order by的右边和$order[1]左边都加了空格
//        p ($this->field);die;
        //用explode函数，将$order进行分割成数组
        $order = explode(',', $order);
        $this->order = 'order by ' . $order[0] . " $order[1]";
//        p ($this->order);die;
        //返回对象从app index那里执行最后的getAll
        return $this;
    }
    //执行有结果集的查询
    //select
    public function q($sql)
    {
        try {
            //执行sql语句
            $res = self::$pdo->query($sql);

            //将结果集取出来
            return $res->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //执行无结果集的sql
    //insert、update、delete
    public function e($sql)
    {
        try {
            return self::$pdo->exec($sql);
        } catch (Exception $e) {
            //输出错误消息
            die($e->getMessage());
        }
    }


}