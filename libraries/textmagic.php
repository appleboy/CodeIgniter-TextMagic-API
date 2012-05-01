<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * TextMagic API Library
 *
 * TextMagic's application programming interface (API) provides the communication link
 * between your application and TextMagic’s SMS Gateway.
 *
 * URL: http://api.textmagic.com/en
 * Author: Bo-Yi Wu <appleboy.tw@gmail.com>
 * Date: 2012-05-01
 */

class Textmagic {

    /*
     * API URL
     */
    const http_api_url = 'https://www.textmagic.com/app/api';

    /*
     * codeigniter instance
     */
    private $_ci;

    /**
     * Base curl settings
     */
    private $_http_status;
    private $_http_response;
    private $_format = 'json';
    protected $session;
    protected $options = array();
    protected $url;

    /**
     * Base config settings
     *
     * @var array $config
     */
    private $_config = array(
        'max_length' => 3
    );

    /**
     * initial api construct
     * return null
     */
    public function __construct($config = array())
    {
        if (count($config) > 0)
        {
            $this->initialize($config);
        }
        $this->_ci =& get_instance();
        $this->_ci->load->config('textmagic');
        $this->_config['api_username'] = $this->_ci->config->item("api_username");
        $this->_config['api_password'] = $this->_ci->config->item("api_password");
    }

    /**
     * Initialize preferences
     *
     * @access  public
     * @param   array
     * @return  this
     */
    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            $this->_config[$key] = $val;
        }

        return $this;
    }

    /**
     * Send text
     *
     * The send command is used to send the SMS message to a mobile phone,
     * or make a scheduled sending.
     *
     * @param string  $text       Text message's content
     * @param array   $phones     Phone numbers array
     * @param boolean $is_unicode Unicode flag
     * @param integer $send_time  Send time in UNIX timestamp
     *
     */
    public function send($text, $phones = array(), $is_unicode = true, $send_time = false)
    {

        $phones = (is_array($phones)) ? join(',', $phones) : $phones;
        $params = array(
            'cmd' => 'send',
            'phone' => rawurlencode($phones),
            'text' => rawurlencode($text),
            'unicode' => $is_unicode ? 1: 0 ,
            'max_length' => $this->_config['max_length']
        );

        if ($send_time) {
            $params['send_time'] = $send_time;
        }

        $params = array_merge(array('username' => $this->_config['api_username'], 'password' => $this->_config['api_password']), $params);

        $options = array(
            CURLOPT_POST => TRUE,
            CURLOPT_SSL_VERIFYHOST => 1,
            CURLOPT_SSL_VERIFYPEER => 0
        );

        return $this->request('post', self::http_api_url, $params, $options);
    }

    /**
     * request data
     * Connect to Nexmo URL API
     *
     * @param array
     * return string
     */
    protected function request($method, $url, $params = array(), $options = array())
    {
        if ($method === 'get')
        {
            // If a URL is provided, create new session
            $this->create($url . ($params ? '?' . http_build_query($params) : ''));
        }
        else
        {
            $data = $params ? http_build_query($params) : '';
            $this->create($url);

            $options[CURLOPT_POSTFIELDS] = $data;

        }
        // TRUE to return the transfer as a string of the return value of curl_exec()
        // instead of outputting it out directly.
        $options[CURLOPT_RETURNTRANSFER] = TRUE;
        $this->options($options);

        return $this->execute();
    }

    protected function options($options = array())
    {
        // Set all options provided
        curl_setopt_array($this->session, $options);

        return $this;
    }

    protected function create($url)
    {
        $this->url = $url;
        $this->session = curl_init($this->url);
        return $this;
    }

    protected function execute()
    {
        // Execute the request & and hide all output
        $this->_http_response = curl_exec($this->session);
        $this->_http_status = curl_getinfo($this->session, CURLINFO_HTTP_CODE);

        curl_close($this->session);

        return $this->response();
    }

    /**
     *
     * set http format (json or xml)
     *
     * @param string
     * @return this
     */
    public function set_format($format = 'json')
    {
        if ($format != 'json' AND $format != 'xml')
            $format = 'json';

        $this->_format = $format;
        return $this;
    }

    /**
     *
     * get http response (json or xml)
     *
     * @return json or xml
     */
    protected function response()
    {
        switch($this->_format)
        {
            case 'xml':
                $response_obj = $this->_http_response;
            break;
            case 'json':
            default:
                $response_obj = json_decode($this->_http_response);
        }

        return $response_obj;
    }

    /**
     *
     * get http response status
     *
     * @return int
     */
    public function get_http_status()
    {
        return (int) $this->_http_status;
    }
}

/* End of file nexmo.php */
/* Location: ./application/libraries/textmagic.php */
