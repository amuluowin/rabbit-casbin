<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 18:47
 */

namespace rabbit\casbin;

use Casbin\Log\Logger as LoggerContract;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package rabbit\casbin
 */
class Logger implements LoggerContract
{
    public $enable = false;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? getDI('logger');
    }

    /**
     * controls whether print the message.
     *
     * @param bool $enable
     */
    public function enableLog($enable)
    {
        $this->enable = $enable;
    }

    /**
     * returns if logger is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enable;
    }

    /**
     * formats using the default formats for its operands and logs the message.
     *
     * @param mixed ...$v
     *
     * @return mixed
     */
    public function write(...$v)
    {
        if (!$this->enable) {
            return;
        }
        $content = '';
        foreach ($v as $value) {
            if (\is_array($value) || \is_object($value)) {
                $value = json_encode($value);
            }
            $content .= $value;
        }
        $this->logger->info($content);
    }

    /**
     * formats according to a format specifier and logs the message.
     *
     * @param $format
     * @param mixed ...$v
     *
     * @return mixed
     */
    public function writef($format, ...$v)
    {
        if (!$this->enable) {
            return;
        }
        $this->logger->info(sprintf($format, ...$v));
    }

}