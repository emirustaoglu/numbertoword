<?php

namespace emirustaoglu\numbertowords;

class paraKuruslari implements \ArrayAccess
{
    private $kurusData;

    public function __construct()
    {
        $this->kurusData = $this->kurus();
    }

    private function kurus()
    {
        return array(
            "TRY" => "KURUŞ",
            "USD" => "CENT",
            "AUD" => "CENT",
            "DKK" => "ÖRE",
            "EUR" => "CENT",
            "GBP" => "",
            "CHF" => "",
            "SEK" => "ÖRE",
            "CAD" => "CENT",
            "KWD" => "DİRHEM",
            "NOK" => "CENT",
            "SAR" => "HALATA",
            "JPY" => "SEN"
        );
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->kurusData[$offset]);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->kurusData[$offset] ?? null;
    }

    /**
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        throw new \Exception("paraKuruslari nesnesi sadece okunabilir.");
    }

    /**
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        throw new \Exception("paraKuruslari nesnesi sadece okunabilir.");
    }
}
