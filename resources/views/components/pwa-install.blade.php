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

    const container =
        document.getElementById('pwa-install-container');

    const button =
        document.getElementById('pwa-install-button');

    if (!container || !button) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Already Installed
    |--------------------------------------------------------------------------
    */

    const isStandalone =
        window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true;

    if (isStandalone) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Install Available Event
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pwa-install-available',
        () => {

            console.log(
                '[PWA UI] Install MGS tersedia.'
            );

            container.style.display = 'block';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Check Current Status
    |--------------------------------------------------------------------------
    */

    if (window.pwaInstallAvailable === true) {

        console.log(
            '[PWA UI] Install MGS sudah tersedia.'
        );

        container.style.display = 'block';

    }


    /*
    |--------------------------------------------------------------------------
    | App Installed
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pwa-installed',
        () => {

            console.log(
                '[PWA UI] App berhasil di-install.'
            );

            container.style.display = 'none';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Install Finished
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pwa-install-finished',
        () => {

            container.style.display = 'none';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Button
    |--------------------------------------------------------------------------
    */

    button.addEventListener(
        'click',
        () => {

            console.log(
                '[PWA UI] Tombol Install MGS diklik.'
            );

            if (
                typeof window.installPwa === 'function'
            ) {

                window.installPwa();

            } else {

                console.error(
                    '[PWA UI] window.installPwa tidak tersedia.'
                );

            }

        }
    );

})();
</script>