<?php
$currentPage = $currentPage ?? '';

function navClass(string $page, string $currentPage): string
{
    return $page === $currentPage ? 'HeaderNavitem NavItemSelected' : 'HeaderNavitem';
}
?>
<header id="MainHeader">
    <div id="FixedHeaderContent">
        <div id="HeaderContent">
            <div id="HeaderToggle" onclick="ToggleMainHeader()"><i id="HeaderToggleIcon"></i></div>
            <a href="/">
                <img src="/Resources/LaserTagVerdenLogo.png" alt="Logo" id="HeaderLogo" />
            </a>
            <nav id="HeaderNavigation">
                <div class="NavSpace"></div>
                <a href="/preise/" class="<?= navClass('preise', $currentPage) ?>">PREISE</a>
                <a href="/reservieren/" class="<?= navClass('reservieren', $currentPage) ?>">RESERVIEREN</a>
                <a href="/galerie/" class="<?= navClass('galerie', $currentPage) ?>">GALERIE</a>
                <a href="/uber-uns/" class="<?= navClass('uber-uns', $currentPage) ?>">ÜBER UNS</a>
                <a href="/kontakt/" class="<?= navClass('kontakt', $currentPage) ?>">KONTAKT</a>
            </nav>
        </div>
    </div>
</header>