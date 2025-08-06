
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                2025
                @if(date('Y') != 2025)
                    - {{ date('Y') }}
                @endif
                © {{ config('app.name') }}
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>

