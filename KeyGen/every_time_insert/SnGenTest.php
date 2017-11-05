<?php
/**
 * @author Liang <liang@twix.idv.tw>
 * @since 20171105 Create
 */
class SnGenTest{

    /**
     * @var pdo $pdo
     */
    private static $pdo = null;

    /**
     * @var string $table
     */
    private static $table = 'sn';

    /**
     * @var string $tokens
     */
    private static $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * 取得 stock db 的pdo 連線
     * @return pdo
     */
    private static function getPdo()
    {
        if(is_null(SELF::$pdo)){

            $dbConfig = array('test'=>
                        array(
                            'type' => 'mysql',
                            'host' => '127.0.0.1',
                            'port' => '3306',
                            'dbname' => 'test',
                            'charset' => 'utf8',
                            'username' => 'username',
                            'password' => 'password'
            ));
            $conf = $dbConfig['test'];
            $dsn = "{$conf['type']}:host={$conf['host']};port={$conf['port']};dbname={$conf['dbname']};charset={$conf['charset']}";
            $username = $conf['username']; 
            $password = $conf['password'];
            $pdo = new PDO($dsn,$username,$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('set names utf8');

            SELF::$pdo = $pdo;
        }
        return SELF::$pdo;
    }

    /**
     * 以亂數產生八碼英數混合序號
     * @return string
     */
    private static function genKey()
    {
        $segment_chars = 8;
        $num_segments = 1;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) {
     
            $segment = '';
     
            for ($j = 0; $j < $segment_chars; $j++) {
                    $segment .= SELF::$tokens[rand(0, 34)];
            }
     
            $key_string .= $segment;
     
            if ($i < ($num_segments - 1)) {
                    $key_string .= '-';
            }
     
        }
        return $key_string;
    }

    /**
     * 取得序號。
     * 檢查DB裡是否重複。
     * 序號寫入DB。
     */
    public static function everyTimeInsert()
    {
        echo __METHOD__.PHP_EOL;
        $table = self::$table;
        $pdo = SELF::getPdo();
        
        //檢查重複的sql
        $sql = "select count(*) as cnt from {$table} where sn = :sn";

        $ps = $pdo->prepare($sql);
        $ps->setFetchMode(PDO::FETCH_ASSOC);

        //序號寫入DB的sql
        $sql1 = "insert $table(name,sn) value(:name,:sn)";
        $psi = self::getPdo()->prepare($sql1);

        $i=1;
        do{
            //以迴圈產生十萬筆序號
            $sn = SELF::genKey();

            //select count db 檢查序號是否已存在DB
            $param[':sn'] = $sn;
            $ps->execute($param);
            $result = $ps->fetch();
    
            if($result['cnt'] == 1){
                //重複 印出通知
                //continue
                echo 'collision'.PHP_EOL;
                continue;
            }else{
                //沒有重複，序號寫入DB
                $data[':name'] = 'everyTime1';
                $data[':sn'] = $sn;
                $psi->execute($data);
            }

            $i++;
        } while($i <= 100000);
        
    }
}

echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB".PHP_EOL;
echo time().PHP_EOL;
SnGenTest::everyTimeInsert();
echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB".PHP_EOL;
echo time().PHP_EOL;
