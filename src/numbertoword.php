<?php

namespace emirustaoglu;


class numbertoword
{
    private $language;
    private $translations;
    private $langFolder;
    private $kuruslar = array(
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

    /**
     * @param string $language Dil kodunu belirtiniz. tr|en varsayılan tr
     * @param string $langFolder Kendi dil dosyanızı kullanacaksınız tam klasör yolunu belirtiniz.
     * @return void
     */
    public function __construct($language = 'tr', $langFolder = "")
    {
        $this->language = $language;
        $this->langFolder = $langFolder;
        $this->loadLanguage();
    }

    private function loadLanguage()
    {
        if ($this->langFolder == "") {
            $filePath = __DIR__ . "/lang/{$this->language}.php";
        } else {
            $filePath = $this->langFolder . "/" . $this->language . ".php";
        }

        if (!file_exists($filePath)) {
            $filePath = __DIR__ . "/lang/tr.php";
        }

        $this->translations = include $filePath;
    }

    /**
     * @param float $sayi Yazıya çevrilecek rakamı iletiniz. Örn: 99.99
     * @param int $kurusbasamak Kuruş hanesinin kaç basamak olacağını beliriniz. Örn: 2
     * @param string $parabirimi Çevrilecek parabirimini belirtiniz. Varsayılan TRY | Desteklenen para birimleri için getCurrencyType() fonksiyonunu kullanabilirsiniz.
     * @return string
     */
    public function convert(float $sayi, int $kurusbasamak, string $parabirimi = "TRY")
    {
        // Dil dosyasından sabitleri al
        $b1 = $this->translations['b1'];
        $b2 = $this->translations['b2'];
        $b3 = $this->translations['b3'];

        $say1 = "";
        $say2 = ""; // say1 virgül öncesi, say2 kuruş bölümü
        $sonuc = "";

        $sayi = str_replace(",", ".", $sayi); // Virgül noktaya çevrilir

        $nokta = strpos($sayi, "."); // Nokta indeksi

        if ($nokta > 0) { // Nokta varsa (kuruş)
            $say1 = substr($sayi, 0, $nokta); // Virgül öncesi
            $say2 = substr($sayi, $nokta, strlen($sayi)); // Virgül sonrası, kuruş
        } else {
            $say1 = $sayi; // Kuruş yoksa
        }

        $son = 0;
        $w = 1; // İşlenen basamak
        $sonaekle = 0; // Binler, milyonlar vb. için sona bin eklenecek mi?
        $kac = strlen($say1); // Kaç rakam var?
        $sonint = 0; // İşlenen basamağın rakamsal değeri
        $uclubasamak = 0; // Hangi basamakta (birler, onlar, yüzler)
        $artan = 0; // Binler, milyonlar vb. artışları yapar
        $gecici = 0;

        if ($kac > 0) { // Virgül öncesinde rakam var mı?
            for ($i = 0; $i < $kac; $i++) {
                $son = $say1[$kac - 1 - $i]; // Son karakterden başlayarak çözümleme yapılır
                $sonint = $son;

                if ($w == 1) { // Birinci basamak
                    $sonuc = $b1[$sonint] . $sonuc;
                } else if ($w == 2) { // İkinci basamak
                    $sonuc = $b2[$sonint] . $sonuc;
                } else if ($w == 3) { // Üçüncü basamak
                    if ($sonint == 1) {
                        $sonuc = $b3[1] . $sonuc;
                    } else if ($sonint > 1) {
                        $sonuc = $b1[$sonint] . $b3[1] . $sonuc;
                    }
                    $uclubasamak++;
                }

                if ($w > 3) {
                    if ($uclubasamak == 1) {
                        if ($sonint > 0) {
                            $sonuc = $b1[$sonint] . $b3[2 + $artan] . $sonuc;
                            if ($artan == 0) {
                                $sonuc = str_replace($b1[1] . $b3[2], $b3[2], $sonuc);
                            }
                            $sonaekle = 1;
                        } else {
                            $sonaekle = 0;
                        }
                        $uclubasamak++;
                    } else if ($uclubasamak == 2) {
                        if ($sonint > 0) {
                            if ($sonaekle > 0) {
                                $sonuc = $b2[$sonint] . $sonuc;
                                $sonaekle++;
                            } else {
                                $sonuc = $b2[$sonint] . $b3[2 + $artan] . $sonuc;
                                $sonaekle++;
                            }
                        }
                        $uclubasamak++;
                    } else if ($uclubasamak == 3) {
                        if ($sonint > 0) {
                            if ($sonint == 1) {
                                $gecici = $b3[1];
                            } else {
                                $gecici = $b1[$sonint] . $b3[1];
                            }
                            if ($sonaekle == 0) {
                                $gecici = $gecici . $b3[2 + $artan];
                            }
                            $sonuc = $gecici . $sonuc;
                        }
                        $uclubasamak = 1;
                        $artan++;
                    }
                }
                $w++;
            }
        }

        if ($sonuc == "") {
            $parabirimi = "";
        }

        $say2 = str_replace(".", "", $say2);
        $kurus = "";

        if ($say2 != "") {
            if ($kurusbasamak > 3) {
                $kurusbasamak = 3;
            }

            $kacc = strlen($say2);

            if ($kacc == 1) {
                $say2 = $say2 . "0";
                $kurusbasamak = 2;
            }

            if (strlen($say2) > $kurusbasamak) {
                $say2 = substr($say2, 0, $kurusbasamak);
            }

            $kac = strlen($say2);
            $w = 1;

            for ($i = 0; $i < $kac; $i++) {
                $son = $say2[$kac - 1 - $i];
                $sonint = $son;

                if ($w == 1) {
                    if ($kurusbasamak > 0) {
                        $kurus = $b1[$sonint] . $kurus;
                    }
                } else if ($w == 2) {
                    if ($kurusbasamak > 1) {
                        $kurus = $b2[$sonint] . $kurus;
                    }
                } else if ($w == 3) {
                    if ($kurusbasamak > 2) {
                        if ($sonint == 1) {
                            $kurus = $b3[1] . $kurus;
                        } else if ($sonint > 1) {
                            $kurus = $b1[$sonint] . $b3[1] . $kurus;
                        }
                    }
                }
                $w++;
            }

            $parakurus = $this->getCurrency($parabirimi);

            if ($kurus == "") {
                $parakurus = "";
            }

            $kurus = $kurus . " " . $parakurus;
        }

        $sonuc = $sonuc . " " . $parabirimi . "," . $kurus . ".";
        return $sonuc;
    }

    public function getCurrencyType()
    {
        return $this->kuruslar;
    }

    private function getCurrency($paraBirim)
    {
        return $this->kuruslar[$paraBirim];
    }
}
