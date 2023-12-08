<footer class="text-center text-lg-start bg-light text-muted">

    <section class="">
        <div class="container text-center text-md-start mt-5 pt-3">
            <div class="row mt-3">
                <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>Randevu Admin
                    </h6>
                    <p>
                        Рандеву Калининград - версия приложение, разработанное как PWA
                        (Progressive Web Application).
                        <br /><br />
                        Актуальная версия приложения {{ config('app.version') }}
                    </p>
                </div>

                <div class="col-md-5 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">{{ __('Контакты') }}</h6>
                    <p><i class="fas fa-home me-3">{{ __('Адрес:') }} </i> Россия, Калининград, 236048</p>
                    <p><i class="fas fa-envelope me-3">Email:</i> alexandr.status@gmail.com</p>
                    <p><i class="fas fa-phone me-3">Тел.:</i> +7 911 487 7251</p>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2022-{{ date('Y', time()) }} Copyright:
        <a class="text-reset fw-bold" href="#">ASt Group</a>
    </div>
</footer>
