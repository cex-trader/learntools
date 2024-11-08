<?php
//多行字符串
$html_content = <<<STR
<div data-v-430bb932="" class="title-box"><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title"><span data-v-430bb932="">Module 1 Getting to know you</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 1 Hello</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 2 My classmates</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 3 My face</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title"><span data-v-430bb932="">Module 2 My family, my friends and me</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 4 I can sing</span><!----></div><div data-v-430bb932="" class="sub-title active"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 5 My family</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 6 My friends</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title"><span data-v-430bb932="">Module 3 Places and activities</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 7 Let's count</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 8 Apples, please</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 9 May I have a pie?</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title"><span data-v-430bb932="">Module 4 The world around us</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 10 On the farm</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 11 In the zoo</span><!----></div><div data-v-430bb932="" class="sub-title"><span data-v-430bb932="" class="dot"></span><span data-v-430bb932="">Unit 12 In the park</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title click"><span data-v-430bb932="">Project 2 My family</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title click"><span data-v-430bb932="">Project 3 Food</span><!----></div></div><div data-v-430bb932="" class="title-container"><div data-v-430bb932="" class="title click"><span data-v-430bb932="">Project 4 The zoo</span><!----></div></div></div>
STR;


// 解析页面内容并提取 sub-title 的文案
function extractSubTitles($html) {

    // 使用 DOMDocument 解析 HTML
    $dom = new DOMDocument;
    libxml_use_internal_errors(true); // 忽略解析中的错误
    $dom->loadHTML($html);
    libxml_clear_errors();

    // 查找所有具有 class="sub-title" 的元素
    $xpath = new DOMXPath($dom);
    $subTitles = $xpath->query("//div[contains(@class, 'sub-title')]/span[2]");

    // 输出所有找到的 sub-title 的内容
    $result = [];
    foreach ($subTitles as $subTitle) {
        $result[] = trim($subTitle->textContent);
    }

    return $result;
}

$subTitles = extractSubTitles($html_content);
$mp3_urls = [];
$pre_url = 'https://szaudio.centuryenglish.com/szyyaudio/audios/textbook/grade-1/';
foreach ($subTitles as $title) {
    // 使用正则表达式匹配标题中的数字
    preg_match('/Unit\s+(\d+)/i', $title, $matches);

    $unit = $matches[1];
    $name = $unit . str_replace(' ', '-', $title) . '.mp3';
    $name = str_replace('?', '', $name);
    $mp3_urls[] = $pre_url . $name;
}

$mp3_urls[] = 'https://szaudio.centuryenglish.com/szyyaudio/audios/textbook/grade-1/Project-2-My-family.mp3';
$mp3_urls[] = 'https://szaudio.centuryenglish.com/szyyaudio/audios/textbook/grade-1/Project-3-Food.mp3';
$mp3_urls[] = 'https://szaudio.centuryenglish.com/szyyaudio/audios/textbook/grade-1/Project-4-The-zoo.mp3';

// 输出结果
print_r($mp3_urls);
foreach ($mp3_urls as $url) {
    $fileName = basename($url);
    echo 'Downloading ' . $fileName . ' ...' . PHP_EOL;
    $file = __DIR__ . '/mp3/' . $fileName;
    file_put_contents($file, file_get_contents($url));
}
