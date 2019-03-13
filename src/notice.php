<?php

class Notice
{
  const transient = 'admin_notice';

  static function add($class, $message, $domain = 'default')
  {
    $notice = Notice::get() ?: '';
    $notice .= sprintf('<div class="notice notice-%s is-dismissible"><p>%s</p></div>', $class, __($message, $domain));
    set_transient(Notice::transient, $notice, HOUR_IN_SECONDS);
  }

  static function get()
  {
    return get_transient(Notice::transient);
  }

  static function remove()
  {
    delete_transient(Notice::transient);
  }

  static function error($message)
  {
    Notice::add('error', $message);
  }

  static function warning($message)
  {
    Notice::add('warning', $message);
  }

  static function success($message)
  {
    Notice::add('success', $message);
  }

  static function info($message)
  {
    Notice::add('info', $message);
  }

  static function show()
  {
    $notice = Notice::get();
    if ($notice) {
      echo $notice;
      Notice::remove();
    }
  }

}
