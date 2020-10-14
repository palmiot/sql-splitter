<?php

/**
 * SQL Splitter CLI Tool.
 *
 * @copyright Copyright (C) David Palmero.
 * @license MIT
 */

namespace Palmiot\SqlSplitter;

use Palmiot\SqlSplitter\SqlSplitter;

/**
 * Class type
 *
 * This tool extends of SqlSplitter class and have the essential for usage the SQLSplitter class from command line interface. Also allow get the source or imput database from stream pipe.
 *
 */
class SqlSplitterCli extends SqlSplitter
{
    /**
     * This variable contains de helper command line info as ascii format.
     * @var string
     */
	private $help = "
	            ****************************************************************************************************************
	            ************************************************* SQL Splitter *************************************************
	            ****************************************************************************************************************
	            *                                                                                                              *
	            *      -i :: File .sql with all databases                                                                      *
	            *      --input :: /path/alldatabases.sql                                                                       *
	            *                                                                                                              *
	            *      -s :: Stream of databases                                                                               *
	            *      --stream :: The output of mysqldump directly                                                            *
	            *                                                                                                              *
	            *      -o :: Folder where will save the splitted databases                                                     *
	            *      --output :: /save/here/                                                                                 *
	            *                                                                                                              *
	            *      -p :: Apply a generic prefix for all splitted databases                                                 *
	            *      --prefix :: test                                                                                        *
	            *                                                                                                              *
	            *      -j :: Save all dump                                                                                     *
	            *      --join :: Also save the all databases as a file                                                         *
	            *                                                                                                              *
	            *      -l :: Display logs                                                                                      *
	            *      --logs :: if something goes wrong                                                                       *
	            *                                                                                                              *
	            *      Usage:                                                                                                  *
	            *                                                                                                              *
	            *      // from input file                                                                                      *
	            *      $ php cli.php -i alldatabases.sql -o databases -p test -j -l                                            *
	            *                                                                                                              *
	            *      // from dump directly                                                                                   *
	            *      $ mysqldump -P port -h ip -u user -ppass --opt --all-databases | php cli.php -s -o databases -j -l      *
	            *                                                                                                              *
	            ****************************************************************************************************************\n";

	/**
     * This variable contains the path or directory of .sql file to split.
     * @var string
     */
	private $input;

    /**
     * This variable get the pipe output of a mysql dump as string format.
     * @var string
     */
	private $stream;

	/**
     * This variable contains the path or directory where save the splitted databases.
     * @var string
     */
	private $output = __DIR__ . '/../databases/';

	/**
     * This variable is the prefix of all output splitted databases.
     * @var string
     */
	private $prefix = '';

	/**
     * This variable means if we want save all splitted databases into a file (the result will be similar to source file).
     * @var boolean
     */
	private $join = false;

    /**
     * This variable define if we want get the output log messages.
     * @var boolean
     */
	private $logs = false;

	/**
	 * This variable define if we want show $help message.
	 * @var boolean
	 */
	private $printHelp = true;

	/**
     * This variable define if the source is a file or an stream pipe.
     * @var boolean
     */
	private $isFile = true;



	/**
	 * This method prepare all before any action.
	 * @method void __construct(array $arguments)
     * @return void
	 */
	public function __construct(array $arguments)
	{
		if ('cli' != php_sapi_name())
		{
		    throw new \Exception('This has to be run from the command line');
		}
		$this->setEnv($arguments);
		if(file_exists($this->input) && is_dir($this->output))
		{
			$this->printHelp = false;
		}
		if(!empty($this->stream) && is_dir($this->output))
		{
	        $this->printHelp = false;
	        $this->isFile = false;
		}
	}

	/**
	 * This method set the arguments from CLI and set the variables of this class before run the parent class.
	 * @method void setEnv(array $arguments)
     * @return void
	 */
	private function setEnv(array $arguments)
	{
		$shortopts = '';
		$shortopts .= 'i:';
		$shortopts .= 's';
		$shortopts .= 'o:';
		$shortopts .= 'p:';
		$shortopts .= 'j';
		$shortopts .= 'l';
		$longopts  = array(
			'input:',
			'stream',
			'output:',
			'prefix:',
			'join',
			'logs'
		);
		$options = (!empty($arguments)) ? $arguments : getopt($shortopts, $longopts);
		$this->input = (array_key_exists('i', $options)) ? $options['i'] : ((array_key_exists('input', $options)) ? $options['input']: $this->input);
		if(isset($options['s']) || isset($options['stream']))
		{
			if(empty($this->input))
			{
				while(!feof(STDIN))
				{
					$this->stream .= fgets(STDIN);
				}
			}
		}
		$this->output = (array_key_exists('o', $options)) ? $options['o'] : ((array_key_exists('output', $options)) ? $options['output']: $this->output);
		$this->prefix = (array_key_exists('p', $options)) ? $options['p'] : ((array_key_exists('prefix', $options)) ? $options['prefix']: $this->prefix);
		$this->join = (isset($options['j']) || isset($options['join'])) ? true : $this->join;
		$this->logs = (isset($options['l']) || isset($options['logs'])) ? true : $this->logs;
	}


	/**
	 * This method pass the arguments to parent class SqlSplitter and do it work for get the result.
	 * @method string run()
     * @return string Logs or Help message
	 */
	public function run()
	{
		if($this->printHelp)
		{
			return $this->help;
		}
		if($this->isFile)
		{
		    parent::setFrom($this->input);
		}
		else
		{
		    parent::setData($this->stream);
		}
		parent::setTo($this->output);
		parent::setPrefix($this->prefix);
		parent::split();
		parent::save();
		if($this->join)
		{
		    parent::saveJoin();
		}
		$resultLog = '';
		if($this->logs)
		{
		    foreach(parent::getLog() as $entry){
		        $resultLog .= $entry->getMessage();
		    }
		}
		return $resultLog;
	}


}
