@extends('template.ui-main')
@section('title', 'Contact')
@section('content')

    <section type="About">
        <div class="container">
            <div class="m-auto p-5 w-75">
                <span class="fs-1 pb-5">
                    Contact
                </span>
                <br>
                <br>
                {!! $pages->contact ?? '' !!}
                <br>
                <ul class="help list-unstyled">
                    <li class="pb-2"><i class="fa-solid fa-mobile"> </i> Cell Number: <a href="tel:+92 313 7709109"
                            class="text-decoration-none text-muted">+92 313 7709109</a></li>
                    <li class="pb-2"><i class="fa-brands fa-whatsapp"> </i> WhatsApp Number: <a href="tel:+92 313 7709109"
                            class="text-decoration-none text-muted">+92 313
                            7709109</a></li>
                    <li class="pb-2"><i class="fa-solid fa-envelope"> </i> Reach us via E-mail: <a
                            href="mailto:info@herbalbyte.store"
                            class="text-decoration-none text-muted">info@herbalbyte.store</a></li>
                </ul>

                <p>
                    Follow us for more details: <br> <a class="text-decoration-none text-muted" href=" https://www.facebook.com/people/Herbal-Byte/61557104567309/">  https://www.facebook.com/people/Herbal-Byte/61557104567309/</a>
                </p>
                <section type="Contact-Form">
                    <div class="container mt-5 p-0">
                        <div class="m-auto ">
                            @include('include.contactform')
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </section>

@endsection
