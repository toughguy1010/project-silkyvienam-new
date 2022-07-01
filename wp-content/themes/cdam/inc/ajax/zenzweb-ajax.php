<?php
foreach (glob(__DIR__."/*.php") as $key => $file_name) {
  require_once($file_name);
}
