<?php

  /**
   * Membuat class socket
   */
  class Socket
  {
    private $errorCode;
    private $errorMessage;
    private $socket;
    private $ipVer = AF_INET;
    private $proto = SOCK_STREAM;
	private $protoPort = 0;
	private $hostTarget = "172.217.26.68";
	private $portTarget = "80";

    public function __construct($argv, $protocolPort = null, $ipVersion = null, $protocol = null)
    {
		$this->setParams($argv);
		
		if ($ipVersion != null) {
			$ipVer = $ipVersion;
		}

		if ($protocol != null) {
			$proto = $protocol;
		}

		if ($protocolPort != null) {
			$this->protoPort = $protocolPort;
		}

		try {
			$this->socket = socket_create($this->ipVer, $this->proto, $this->protoPort);
		}

		catch (Exception $e) {
			$errorCode = socket_last_error();
			$errorMessage = socket_strerror($errorCode);
		}
	}
	
	/*
	 * Public Methods
	 */
    public function getErrorMessage()
    {
      return $errorMessage;
    }

    public function getErrorCode()
    {
      return $errorCode;
    }
  	
	public function connect()
  	{
  		if (!socket_connect($this->socket, $this->hostTarget, $this->portTarget)) {
  			$this->errorCode = socket_last_error();
  			$this->errorMessage = socket_strerror($this->errorCode);

  			die("Error: " . $this->errorCode . "\n" . $this->errorMessage);
  		} else {
  			echo "Success";
  		}

  	}

	public function send($message)
	{
		if (!socket_send($this->socket, $message, mb_strlen($message), MSG_OOB)) {
			$this->errorCode = socket_last_error();
			$this->errorMessage = socket_strerror($this->errorCode);
		}
	}
	/*
	 * Private Methods
	 */
	private function setParams($argv)
	{
		if (isset($argv[1])) {
			$this->hostTarget = $argv[1];
		}
		
		if (isset($argv[2])) {
			$this->portTarget = $argv[2];
		}
	}
	
	/*
	 * Static Methods
	 */
	public static function dump()
	{
		var_dump($argv);
	}
  }
