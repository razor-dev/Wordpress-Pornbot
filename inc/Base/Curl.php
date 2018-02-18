<?php
/**
 * Created by PhpStorm.
 * @package RzaPlugin
 * User: razor
 * Date: 2/6/2018
 * Time: 8:58 PM
 */

namespace inc\Base;
class Curl
{
    /** @var string */
    protected $url;
    /** @var object */
    protected $ch;

    /** @var array */
    public $options = array();

    /** @var int */
    private $error_code = 0;

    /** @var string */
    private $data = null;

    /**
     * Class default constructor
     */
    public function __construct()
    {
        if(!function_exists('curl_init')){
            echo 'You must have CURL enabled in order to use Curl extension.';
        }
    }

    /**
     * Format url
     * @param $url
     * @internal param
     */
    public function setUrl($url)
    {
        if(!preg_match('!^\w+://! i', $url)){
            $url = 'http://' . $url;
        }
        $this->url = $url;
    }

    /**
     * Setup http login
     * @param string $username
     * @param string $password
     * @return void
     */
    public function setHttpLogin($username = '', $password = '')
    {
        $this->setOption(CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * Set proxy
     * @param $url
     * @param int $port
     * @return void
     */
    public function setProxy($url, $port = 80)
    {
        $this->setOption(CURLOPT_HTTPPROXYTUNNEL, true);
        $this->setOption(CURLOPT_PROXY, $url . ':' . $port);
    }

    /**
     * Set proxy login
     * @param string $username
     * @param string $password
     * @return void
     */
    public function setProxyLogin($username = '', $password = '')
    {
        $this->setOption(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
    }

    /**
     * Set any extra option
     * @param $key
     * @param $value
     * @return void
     */
    protected function setOption($key, $value)
    {
        curl_setopt($this->ch, $key, $value);
    }

    /**
     * Default options
     * @return void
     */
    protected function setDefaults()
    {
        if(!isset($this->options['timeout'])){
            $this->setOption(CURLOPT_TIMEOUT, 30);
        }
        if(!isset($this->options['setOptions'][CURLOPT_HEADER])){
            $this->setOption(CURLOPT_HEADER, false);
        }
        if(!isset($this->options['setOptions'][CURLOPT_ENCODING])){
            $this->setOption(CURLOPT_ENCODING, 'UTF-8');
        }
        if(!isset($this->options['setOptions'][CURLOPT_RETURNTRANSFER])){
            $this->setOption(CURLOPT_RETURNTRANSFER, true);
        }
        if(!isset($this->options['setOptions'][CURLOPT_FOLLOWLOCATION])){
            $this->setOption(CURLOPT_FOLLOWLOCATION, false);
        }
        if(!isset($this->options['setOptions'][CURLOPT_FRESH_CONNECT])){
            $this->setOption(CURLOPT_FRESH_CONNECT, true);
        }
    }

    /**
     * Has error
     * @return bool
     */
    public function hasErrors()
    {
        return $this->error_code !== 0;
    }

    /**
     * Return data
     * @param bool $decode
     * @return string
     */
    public function getData($decode = false)
    {
        return ($decode===false) ? $this->data : json_decode($this->data, true);
    }

    /**
     * Return Header Data
     * @return array
     */
    public function getHeader()
    {
        return self::get_headers_from_curl_response($this->data);
    }

    /**
     * Handle curl
     * @param $url
     * @param array $postData
     * @return $this
     */
    private function handleCurl($url, $postData, array $header, $method)
    {
        $this->setUrl($url);
        $clean = true;
        if ($method === 'HEAD'){
            $clean = false;
        }
        if(!$this->url){
            echo 'You must set Url.';
            die();
        }

        $this->ch = curl_init();
        if (!empty($header)){
            $this->setOption(CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            $this->setOption(CURLOPT_HTTPHEADER, $header);
        }

        if(empty($postData)){
            $this->setOption(CURLOPT_URL, $this->url);

            $this->setDefaults();
            if (!empty($header)){
                if ($clean){
                    $this->setOption(CURLOPT_HEADER, 0);
                }else{
                    $this->setOption(CURLOPT_HEADER, 1);
                }
            }
        }else{

            if(!is_array($postData)){
                echo '$postData must be an array type.';
                die();
            }
            $this->setOption(CURLOPT_URL, $this->url);
            $this->setDefaults();
            $this->setOption(CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            $this->setOption(CURLOPT_POST, true);
            $this->setOption(CURLOPT_POSTFIELDS, $postData);
        }
        if (!empty($method)){
            $this->setOption(CURLOPT_CUSTOMREQUEST, $method);
        }

        $this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, 0);

        if(isset($this->options['setOptions'])){
            foreach($this->options['setOptions'] as $k => $v){
                $this->setOption($k, $v);
            }
        }
        $this->data = curl_exec($this->ch);

        if($this->data === false or $this->data === null){
            $this->error_code = curl_errno($this->ch);
            echo "Error code - $this->error_code. Error message - $this->ch.";
        }else{
            echo  curl_getinfo($this->ch);
        }
        curl_close($this->ch);

        return $this;
    }

    /*
     * Convert CURL response header to array
     * @param string $response
     * @return array
     */
    protected static function get_headers_from_curl_response($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else
            {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        return $headers;
    }

    public function is_JSON($args) {
        json_decode($args);
        return (json_last_error()===JSON_ERROR_NONE);
    }

    /**
     * Running curl
     * @param $url
     * @param array $postData
     * @return mixed
     */
    public function run($url, $postData, $header = array(), $method)
    {
        if(!Validator::isUrl($url)){
            echo 'The parameter $url must be a valid URL string value!';
            return false;
        }
        $reflection = new ReflectionMethod(get_class($this), 'handleCurl');
        $reflection->setAccessible(true);
        return $reflection->invokeArgs($this, array($url, $postData, $header, $method));
    }

    public function nodePush($params)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://api.crypto-dev.com/notify.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'act='.$params['act'].'&details='.json_encode($params['details']));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);
    }
}