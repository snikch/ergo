<?php

/**
 * A basic handler for PHP errors and exceptions which consolidates errors
 * into error exceptions provides for simple logging and error formatting.
 */
abstract class Ergo_Error_AbstractErrorHandler
	implements Ergo_Error_ErrorHandler
{
	private $_proxy;
	private $_logger;

	/**
	 * Constructor
	 * @param object an optional Ergo_Logger instance
	 */
	public function __construct($logger=null)
	{
		if(is_object($logger))
		{
			$this->_logger = new Ergo_Logging_LoggerMultiplexer();
			$this->_logger->addLoggers($logger);
		}
	}

	/* (non-phpdoc)
	 * @see Ergo_Error_ErrorHandler::logger()
	 */
	public function logger()
	{
		if(!isset($this->_logger))
		{
			$this->_logger = new Ergo_Logging_LoggerMultiplexer();
		}

		return $this->_logger;
	}

	/* (non-phpdoc)
	 * @see Ergo_Error_ErrorHandler::context()
	 */
	public function context()
	{
		return array();
	}

	/**
	* Determines whether an exception is recoverable
	* @return bool
	*/
	protected function isExceptionRecoverable($e)
	{
		if ($e instanceof ErrorException)
		{
			$ignore = E_WARNING | E_NOTICE | E_USER_WARNING | E_USER_NOTICE | E_STRICT;
			return (($ignore & $e->getSeverity()) != 0);
		}

		return false;
	}

	/**
	* Determines whether the exception should halt execution
	* @return bool
	*/
	protected function isExceptionHalting($e)
	{
		return true;
	}
}
