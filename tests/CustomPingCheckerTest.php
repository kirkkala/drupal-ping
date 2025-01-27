<?php

use \PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CustomPingChecker
 */
class CustomPingCheckerTest extends TestCase {

  public static function setUpBeforeClass(): void {
    require_once 'init.php';
  }

  /**
   * @covers ::check2
   */
  public function testCheckSuccess(): void {
    $c = new CustomPingChecker();
    file_put_contents('_ping.custom.php', '<?php');
    $c->check();
    $status = $c->getStatusInfo();
    $this->assertEquals(['success', ''], $status);
  }

  /**
   * @covers ::check2
   */
  public function testCheckDisabled(): void {
    $c = new CustomPingChecker();
    unlink('_ping.custom.php');
    $c->check();
    $status = $c->getStatusInfo();
    $this->assertEquals(['disabled', ''], $status);
  }

  /**
   * @covers ::check2
   */
  public function testCheckCustom(): void {
    $c = new CustomPingChecker();
    file_put_contents('_ping.custom.php', <<<PHP
<?php
\$status = 'custom';
PHP
    );
    $c->check();
    $status = $c->getStatusInfo();
    $this->assertEquals(['custom', ''], $status);
  }

  /**
   * @covers ::check2
   */
  public function testCheckWarnings(): void {
    $c = new CustomPingChecker();
    file_put_contents('_ping.custom.php', <<<PHP
<?php
\$status = '';
\$this->warnings[] = 'The warning.';
PHP
    );
    $c->check();
    $status = $c->getStatusInfo();
    $this->assertEquals(['warning', 'The warning.'], $status);
  }

}
