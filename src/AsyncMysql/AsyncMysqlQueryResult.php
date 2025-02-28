<?hh // strict

namespace Slack\SQLFake;

// HHAST_IGNORE_ALL[BannedHackCollections]

use namespace HH\Lib\C;

/* HH_FIXME[2049] */
<<__MockClass>>
final class AsyncMysqlQueryResult extends \AsyncMysqlQueryResult {

  /* HH_IGNORE_ERROR[3012] I don't want to call parent::construct */
  public function __construct(private dataset $rows, private int $rows_affected = 0, private int $last_insert_id = 0) {}

  public function rows(): dataset {
    return $this->rows;
  }

  <<__Override>>
  public function numRowsAffected(): int {
    return $this->rows_affected;
  }

  <<__Override>>
  public function lastInsertId(): int {
    return $this->last_insert_id;
  }

  <<__Override>>
  public function numRows(): int {
    return C\count($this->rows);
  }

  <<__Override>>
  public function mapRows(): Vector<Map<string, string>> {
    $out = Vector {};
    foreach ($this->rows as $row) {
      $map = Map {};
      foreach ($row as $column => $value) {
        // in the untyped version, all columns are `?string`
        $map->set($column, $value is nonnull ? (string)$value : null);
      }
      $out->add($map);
    }
    /*HH_IGNORE_ERROR[4110]
      The actual return type of this function is `Vector<Map<string, ?string>>`
      The parent class is typed incorrectly in the HHI file.
      @TODO Update the return type once we target HHVM ~4.16.
     */
    return $out;
  }

  <<__Override>>
  public function mapRowsTyped(): Vector<Map<string, mixed>> {
    $out = Vector {};
    foreach ($this->rows as $row) {
      $out->add(new Map($row));
    }
    return $out;
  }

  <<__Override>>
  public function vectorRows(): Vector<Vector<string>> {
    $out = Vector {};
    foreach ($this->rows as $row) {
      $v = Vector {};
      foreach ($row as $value) {
        // in the untyped version, all columns are `?string`
        $v->add($value is nonnull ? (string)$value : null);
      }
      $out->add($v);
    }
    /*HH_IGNORE_ERROR[4110]
      The actual return type of this function is `Vector<Vector<?string>>`
      The parent class is typed incorrectly in the HHI file.
      @TODO Update the return type once we target HHVM ~4.16.
     */
    return $out;
  }

  <<__Override>>
  public function vectorRowsTyped(): Vector<Vector<mixed>> {
    $out = Vector {};
    foreach ($this->rows as $row) {
      $v = Vector {};
      foreach ($row as $value) {
        $v->add($value);
      }
      $out->add($v);
    }
    return $out;
  }

  <<__Override>>
  public function rowBlocks(): mixed {
    throw new SQLFakeNotImplementedException('row blocks not implemented');
  }

  <<__Override>>
  public function noIndexUsed(): bool {
    // TODO: it would be really interesting to actually try to determine if a query could use an index
    // and set this value so that this could be instrumented in tests
    return true;
  }

  <<__Override>>
  public function recvGtid(): string {
    return 'stubbed';
  }

  <<__Override>>
  public function elapsedMicros(): int {
    return 100;
  }
}
