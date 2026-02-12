<div class="footer card">
    This website was created to collect and catalogue the most recent menus of the restaurants in and around
    <a href="https://en.wikipedia.org/wiki/Thunder_Bay"> Thunder Bay, Ontario, Canada</a> so you can find them quickly
    and easily
    without QR codes, third party delivery apps or
    navigating a complicated website.
    <br>For now we are focused on locally owned and operated eateries. If you see something out of date - send me a copy
    of the latest
    menu and I'll credit you!
    <br>DISCLAIMER!!!: I'm totally not affiliated with ANY of these restaurants; No guarantees of any kind are implied
    by
    this website; AI was used to create the text transcriptions of menus and as such, they are for entertainment
    purposes only.
    <br>ADVERTISING HERE: Hey, if you want to post your ad here, just get in touch! I promise it's cheaper than you
    expect!
    <br>Privacy Policy / Footer: I'm using very limited <a href='index.php?stats'>statistics</a> to see how many people
    are viewing the site.
    <br>Website ©2026 <a href="https://www.gartekstudios.ca"> Gartek Studios</a>
    <?php
    if (file_exists('visitorcount.txt')) {
        $visitorcount = trim(file_get_contents('visitorcount.txt'));
        echo "<br> " . htmlspecialchars($visitorcount) . " SERVED (at last count)";
    }
    ?>
</div>