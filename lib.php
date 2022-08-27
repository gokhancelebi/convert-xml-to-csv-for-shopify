<?php

function seo_($str){
    $before = array(
        'àáâãäåòóôõöøèéêëðçìíîïùúûüñšž',
        '/[^a-z0-9\s]/',
        array('/\s/', '/--+/', '/---+/')
    );

    $after = array(
        'aaaaaaooooooeeeeeciiiiuuuunsz',
        '',
        '-'
    );

    $str = strtolower($str);
    $str = strtr($str, $before[0], $after[0]);
    $str = preg_replace($before[1], $after[1], $str);
    $str = trim($str);
    $str = preg_replace($before[2], $after[2], $str);

    return $str;
}


function sef($string)
{
    $str = strtolower($string);

    //Specific language transliteration.
    //This one is for latin 1, latin supplement , extended A, Cyrillic, Greek

    $glyph_array = array(
        'a' => 'a,à,á,â,ã,ä,å,ā,ă,ą,ḁ,α,ά',
        'ae' => 'æ',
        'b' => 'β,б',
        'c' => 'c,ç,ć,ĉ,ċ,č,ћ,ц',
        'ch' => 'ч',
        'd' => 'ď,đ,Ð,д,ђ,δ,ð',
        'dz' => 'џ',
        'e' => 'e,è,é,ê,ë,ē,ĕ,ė,ę,ě,э,ε,έ',
        'f' => 'ƒ,ф',
        'g' => 'ğ,ĝ,ğ,ġ,ģ,г,γ',
        'h' => 'ĥ,ħ,Ħ,х',
        'i' => 'i,ì,í,î,ï,ı,ĩ,ī,ĭ,į,и,й,ъ,ы,ь,η,ή',
        'ij' => 'ĳ',
        'j' => 'ĵ,j',
        'ja' => 'я',
        'ju' => 'яю',
        'k' => 'ķ,ĸ,κ',
        'l' => 'ĺ,ļ,ľ,ŀ,ł,л,λ',
        'lj' => 'љ',
        'm' => 'μ,м',
        'n' => 'ñ,ņ,ň,ŉ,ŋ,н,ν',
        'nj' => 'њ',
        'o' => 'ò,ó,ô,õ,ø,ō,ŏ,ő,ο,ό,ω,ώ',
        'oe' => 'œ,ö',
        'p' => 'п,π',
        'ph' => 'φ',
        'ps' => 'ψ',
        'r' => 'ŕ,ŗ,ř,р,ρ,σ,ς',
        's' => 'ş,ś,ŝ,ş,š,с',
        'ss' => 'ß,ſ',
        'sh' => 'ш',
        'shch' => 'щ',
        't' => 'ţ,ť,ŧ,τ,т',
        'th' => 'θ',
        'u' => 'u,ù,ú,û,ü,ũ,ū,ŭ,ů,ű,ų,у',
        'v' => 'в',
        'w' => 'ŵ',
        'x' => 'χ,ξ',
        'y' => 'ý,þ,ÿ,ŷ',
        'z' => 'ź,ż,ž,з,ж,ζ'
    );

    foreach ($glyph_array as $letter => $glyphs) {
        $glyphs = explode(',', $glyphs);
        $str = str_replace($glyphs, $letter, $str);
    }

    return $str;
}



function xml_attribute($object, $attribute)
{
    if (isset($object[$attribute])) {
        return (string)$object[$attribute];
    }
}

