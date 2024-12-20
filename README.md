```numbertoword

  ____  _   _ ____            _   _                 _              _____  __        __            _ 
 |  _ \| | | |  _ \          | \ | |_   _ _ __ ___ | |__   ___ _ _|_   _|_\ \      / /__  _ __ __| |
 | |_) | |_| | |_) |  _____  |  \| | | | | '_ ` _ \| '_ \ / _ \ '__|| |/ _ \ \ /\ / / _ \| '__/ _` |
 |  __/|  _  |  __/  |_____| | |\  | |_| | | | | | | |_) |  __/ |   | | (_) \ V  V / (_) | | | (_| |
 |_|   |_| |_|_|             |_| \_|\__,_|_| |_| |_|_.__/ \___|_|   |_|\___/ \_/\_/ \___/|_|  \__,_|


```


## 📜 Genel Bilgiler

**Proje Adı:** `numbertoword`

`numbertoword` ile faturaların açıklama kısmında ödeme tutarını yazıyla kolayca belirtebilirsiniz.

## 🚀 Kurulum

**PHP NumberToWord** kurulumunu, proje ana dizininde aşağıdaki komutu yazarak kolayca gerçekleştirebilirsiniz:

```bash
composer require emirustaoglu/numbertoword
```

veya `composer.json` dosyanıza aşağıdaki satırları ekleyerek manuel kurulum yapabilirsiniz

```bash
{
    "require": {
        "emirustaoglu/numbertoword": "^1.0.0"
    }
}
```

Daha sonrasında aşağıdaki komutu çalıştırın

```bash
composer install
```

## ⚙️ Gereksinimler

- PHP Sürümü:
    - Minimum: PHP 7.4
    - Tavsiye Edilen: PHP 8.1 veya üzeri

## 💻 Kullanım Örneği

```php
use emirustaoglu\numbertoword;
/**
* @param string $language  Dil kodunu belirtiniz. tr|en varsayılan tr
* @param string $langFolder Kendi dil dosyanızı kullanacaksınız tam klasör yolunu belirtiniz.
* @return void
*/
$convert = new numbertoword();
/**
@param float $sayi   Yazıya çevrilecek rakamı iletiniz. Örn: 99.99
@param int $kurusbasamak Kuruş hanesinin kaç basamak olacağını beliriniz. Örn: 2 
@param string $parabirimi    Çevrilecek parabirimini belirtiniz. Varsayılan TRY | Desteklenen para birimleri için getCurrencyType() fonksiyonunu kullanabilirsiniz.
@return string
*/
$numberToWord = $convert->convert(999.99, 3, "TRY");

echo $numberToWord;
```

## 🌐 Dil Ayarlaması

Proje içerisinde ingilizce ve türkçe olarak dil desteği bulunmaktadır. 

```php
//Parametre verilmez ise varsayılan dil türkçedir. 
$convert = new numbertowords("en");
```

**Kendi Dil Dosyasınızı Oluşturma**

```php

return [
    'b1' => ["", "BİR", "İKİ", "ÜÇ", "DÖRT", "BEŞ", "ALTI", "YEDİ", "SEKİZ", "DOKUZ"],
    'b2' => ["", "ON", "YİRMİ", "OTUZ", "KIRK", "ELLİ", "ALTMIŞ", "YETMİŞ", "SEKSEN", "DOKSAN"],
    'b3' => ["", "YÜZ", "BİN", "MİLYON", "MİLYAR", "TRİLYON", "KATRİLYON"],
];
```

Örneğin, de.php şeklinde bir dosya oluşturup yukarıdaki değerlerin dildeki karşılıklarını yazarak kendi dil dosyanızı oluşturabilirsiniz.

## 🛠️ Özel Dil Dosyasının Kullanımı

````php
/**
* @param string $language  Dil kodunu belirtiniz. tr|en varsayılan tr
* @param string $langFolder Kendi dil dosyanızı kullanacaksınız tam klasör yolunu belirtiniz.
* @return void
*/
$convert = new numbertowords("de", __DIR__ . '/lang/');
````

## 🤝 Katkıda Bulunma
Bu proje açık kaynaklıdır. İsteyen herkes katkıda bulunabilir.

1. Projeyi forklayın ( https://github.com/emirustaoglu/numbertoword/fork )
2. Özellik dalınızı (branch) oluşturun (git checkout -b yeni-ozellik)
3. Değişikliklerinizi commitleyin (git commit -am 'Yeni özellik eklendi')
4. Dalınıza push yapın (git push origin yeni-ozellik)
5. Yeni bir Pull Request oluşturun

## 📜 Lisans
Bu proje [MIT](http://opensource.org/licenses/MIT) Lisansı altında lisanslanmıştır. Dilediğiniz gibi kullanabilir ve dağıtabilirsiniz.

### 🎉 Kullandığınız için Teşekkürler!
