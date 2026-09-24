<div
    id="pwa-install-container"
    style="display: none;"
>
    <div
        style="
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        "
    >
        <div>
            <div
                style="
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 5px;
                "
            >
                📱 Install MGS
            </div>

            <div
                style="
                    color: #6b7280;
                    font-size: 14px;
                "
            >
                Pasang Mirai Gresik System di perangkat Anda
                agar lebih mudah diakses seperti aplikasi.
            </div>
        </div>

        <button
            type="button"
            id="pwa-install-button"
            style="
                border: 0;
                border-radius: 7px;
                padding: 9px 16px;
                background: #4f46e5;
                color: #ffffff;
                cursor: pointer;
                font-size: 14px;
                font-weight: 600;
                white-space: nowrap;
            "
        >
            Install MGS
        </button>
    </div>
</div>

<script>
(() => {

    let deferredPrompt = null;

    const container = document.getElementById(
        'pwa-install-container'
    );

    const button = document.getElementById(
        'pwa-install-button'
    );

    if (!container || !button) {
        console.warn('[PWA UI] Element tidak ditemukan.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Standalone
    |--------------------------------------------------------------------------
    */

    const isStandalone =
        window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true;

    if (isStandalone) {
        console.log('[PWA UI] Aplikasi sudah berjalan sebagai PWA.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | beforeinstallprompt
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeinstallprompt',
        (event) => {

            console.log(
                '[PWA UI] 🔥 beforeinstallprompt diterima langsung oleh component.'
            );

            event.preventDefault();

            deferredPrompt = event;

            container.style.display = 'block';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Install Button
    |--------------------------------------------------------------------------
    */

    button.addEventListener(
        'click',
        async () => {

            console.log(
                '[PWA UI] Tombol Install MGS diklik.'
            );

            if (!deferredPrompt) {

                console.warn(
                    '[PWA UI] Install prompt belum tersedia.'
                );

                return;
            }

            deferredPrompt.prompt();

            const result =
                await deferredPrompt.userChoice;

            console.log(
                '[PWA UI] Install result:',
                result.outcome
            );

            deferredPrompt = null;

            container.style.display = 'none';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | App Installed
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'appinstalled',
        () => {

            console.log(
                '[PWA UI] ✅ MGS berhasil di-install.'
            );

            deferredPrompt = null;

            container.style.display = 'none';

        }
    );

})();
</script>