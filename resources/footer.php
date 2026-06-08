<?php
$currentFooter = $currentFooter ?? '';

function footerClass(string $page, string $currentFooter): string
{
    return $page === $currentFooter ? 'FooterNavItem NavItemSelected' : 'FooterNavItem';
}
?>
<footer id="MainFooter">
    <nav id="FooterNavigation">
        <a href="/impressum/" class="<?= footerClass('impressum', $currentFooter) ?>">IMPRESSUM</a>
        <a href="/agb/" class="<?= footerClass('agb', $currentFooter) ?>">AGB</a>
        <a href="/datenschutz/" class="<?= footerClass('datenschutz', $currentFooter) ?>">DATENSCHUTZ</a>
        <div class="NavSpace"></div>
    </nav>
</footer>