
<ul class="nav nav-tabs mb-3" id="recapTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active"
            id="academic-tab"
            data-toggle="tab"
            href="#academic"
            role="tab"
            aria-controls="academic"
            aria-selected="true">
            <i class="fas fa-chart-line mr-1"></i>
            Nilai Akademik
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            id="attitude-tab"
            data-toggle="tab"
            href="#attitude"
            role="tab"
            aria-controls="attitude"
            aria-selected="false">
            <i class="fas fa-user-check mr-1"></i>
            Nilai Sikap
        </a>
    </li>
</ul>

<div class="tab-content" id="recapTabsContent">
    <div class="tab-pane fade show active"
        id="academic"
        role="tabpanel"
        aria-labelledby="academic-tab">

        @include('score-recaps.partials.academic-recap')
    </div>

    <div class="tab-pane fade"
        id="attitude"
        role="tabpanel"
        aria-labelledby="attitude-tab">

        @include('score-recaps.partials.attitude-recap')
    </div>
</div>






<script>
(function () {
    const storageKey =
        'score-recap-active-tab:' + window.location.pathname;

    const validTabs = ['#academic', '#attitude'];

    function activateTab(target) {
        if (!validTabs.includes(target)) return;

        const tab = document.querySelector(
            '#recapTabs a[href="' + target + '"]'
        );

        const pane = document.querySelector(target);

        if (!tab || !pane) return;

        // Nonaktifkan semua tombol dan panel
        document.querySelectorAll('#recapTabs a[data-toggle="tab"]')
            .forEach(function (item) {
                item.classList.remove('active');
                item.setAttribute('aria-selected', 'false');
            });

        document.querySelectorAll('#recapTabsContent .tab-pane')
            .forEach(function (item) {
                item.classList.remove('show', 'active');
            });

        // Aktifkan tombol dan panel yang dipilih
        tab.classList.add('active');
        tab.setAttribute('aria-selected', 'true');
        pane.classList.add('show', 'active');
    }

    // Pulihkan tab sebelum pengguna berinteraksi
    const savedTab = localStorage.getItem(storageKey);
    const hash = window.location.hash;

    const initialTab = validTabs.includes(hash)
        ? hash
        : (validTabs.includes(savedTab) ? savedTab : '#academic');

    activateTab(initialTab);

    // Simpan tab setiap kali tombol diklik
    document.querySelectorAll('#recapTabs a[data-toggle="tab"]')
        .forEach(function (tab) {
            tab.addEventListener('click', function () {
                const target = this.getAttribute('href');

                if (!validTabs.includes(target)) return;

                localStorage.setItem(storageKey, target);
                history.replaceState(
                    null,
                    '',
                    window.location.pathname +
                    window.location.search +
                    target
                );

                activateTab(target);
            });
        });
})();
</script>