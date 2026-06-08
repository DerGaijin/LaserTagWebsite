<?php
$currentPage = $currentPage ?? '';

function navClass(string $page, string $currentPage): string
{
    $classes = 'm-[5px] p-[5px] text-xl text-inherit no-underline whitespace-nowrap';

    return $page === $currentPage ? $classes . ' border-b-[3px] border-[aqua]' : $classes;
}
?>
<header id="MainHeader" class="relative h-[140px] w-full max-[910px]:h-[180px]">
    <div id="FixedHeaderContent" class="fixed z-[5] mt-2.5 flex w-full flex-col justify-between border-y-[5px] border-[#00aaaa] bg-[#151515] text-white transition-transform duration-200 ease-in-out max-[910px]:-translate-y-[245px]">
        <div id="HeaderContent" class="flex items-center p-2.5 max-[910px]:flex-col-reverse">
            <div id="HeaderToggle" class="hidden w-full cursor-pointer justify-center p-[5px] max-[910px]:flex" onclick="ToggleMainHeader()"><i id="HeaderToggleIcon" class="translate-y-[-4px] rotate-45 border-b-[3px] border-r-[3px] border-white p-[7px]"></i></div>
            <a href="/">
                <img src="/Resources/LaserTagVerdenLogo.png" alt="Logo" id="HeaderLogo" class="w-[var(--logo-w)]" />
            </a>
            <nav id="HeaderNavigation" class="flex w-full max-[910px]:flex-col max-[910px]:items-center">
                <div class="w-full max-[910px]:hidden"></div>
                <a href="/preise/" class="<?= navClass('preise', $currentPage) ?>">PREISE</a>
                <a href="/reservieren/" class="<?= navClass('reservieren', $currentPage) ?>">RESERVIEREN</a>
                <a href="/galerie/" class="<?= navClass('galerie', $currentPage) ?>">GALERIE</a>
                <a href="/uber-uns/" class="<?= navClass('uber-uns', $currentPage) ?>">ÜBER UNS</a>
                <a href="/kontakt/" class="<?= navClass('kontakt', $currentPage) ?>">KONTAKT</a>
            </nav>
        </div>
    </div>
</header>
