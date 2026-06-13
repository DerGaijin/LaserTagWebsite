<?php
$currentFooter = $currentFooter ?? '';
$scriptDirectory = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$relativeRoot = $scriptDirectory === '' ? '' : str_repeat('../', substr_count($scriptDirectory, '/') + 1);

function footerClass(string $page, string $currentFooter): string
{
    $classes = 'm-[5px] p-[5px] text-xl text-inherit no-underline whitespace-nowrap';

    return $page === $currentFooter ? $classes . ' border-b-[3px] border-[aqua]' : $classes;
}
?>
<footer id="MainFooter" class="my-5 flex w-full justify-between border-y-2 border-[#00aaaa] bg-[#151515] p-2.5 text-white shadow-[0_-5px_15px_black]">
    <nav id="FooterNavigation" class="flex w-full items-center max-[670px]:flex-wrap max-[670px]:justify-center">
        <a href="<?= $relativeRoot ?>impressum/" class="<?= footerClass('impressum', $currentFooter) ?>">IMPRESSUM</a>
        <a href="<?= $relativeRoot ?>agb/" class="<?= footerClass('agb', $currentFooter) ?>">AGB</a>
        <a href="<?= $relativeRoot ?>datenschutz/" class="<?= footerClass('datenschutz', $currentFooter) ?>">DATENSCHUTZ</a>
        <div class="w-full max-[670px]:hidden"></div>
        <a href="<?= $relativeRoot ?>muttizettel/" class="<?= footerClass('muttizettel', $currentFooter) ?>">MUTTIZETTEL</a>
    </nav>
</footer>
