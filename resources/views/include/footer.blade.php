<?php
if (isset($_GET['signature'])) {?>
<section type="footer">
    <div class="container-fluid bg-light mt-5 border-top ">
        <div class="container">
            <div class="row ">
                <div class="col-12 pt-4 pb-4">
                    <span class="fst-italic text-muted"> © 2024, Byte Mart Powered by Ecomify .
                        <a href="#" class="text-decoration-none text-muted privacyPolicy">Privacy policy</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}else{?>
<section type="footer">
    <div class="container-fluid bg-light mt-5 p-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 pt-5">
                    <div>
                        <h5 class="mb-4">About US</h5>
                        <p class="text-muted">Byte Mart is an online toys store with an amazing range of toys. We
                            offer a large variety of toys at discounted prices to facilitate our customers. Our
                            primary focus is customer satisfaction. We provide very flexible delivery services at
                            customers' doorstep.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 pt-5">
                    <div>
                        <h5 class="mb-4">Help</h5>
                        <ul class="help list-unstyled">
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'faq']) }}" class="text-decoration-none text-muted">FAQ</a>
                            </li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'how_to_order']) }}" class="text-decoration-none text-muted">How To
                                    Order</a></li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'shipping_details']) }}" class="text-decoration-none text-muted">Shipping
                                    Details</a></li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'payment_details']) }}" class="text-decoration-none text-muted">Payment
                                    Details</a></li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'about']) }}" class="text-decoration-none text-muted">About
                                    Us</a></li>
                            <li class="pb-2"><a href="{{ route('store.contact', ['shop' => request()->shop->name]) }}" class="text-decoration-none text-muted">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 pt-5">
                    <div>
                        <h5 class="mb-4">Policy</h5>
                        <ul class="help list-unstyled">
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'privacy_policy']) }}" class="text-decoration-none text-muted">Privacy
                                    Policy</a></li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'return_refund']) }}" class="text-decoration-none text-muted">Return &
                                    Refund</a></li>
                            <li class="pb-2"><a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'terms_of_service']) }}" class="text-decoration-none text-muted">Terms of
                                    Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 pt-5">
                    <div>
                        <h5 class="mb-4">Contact Us</h5>
                        <p class="text-muted">Dear Valued Customers for your Complaints & Suggestions Reach Us at
                            Our Following Contact Details.</p>
                        <ul class="help list-unstyled">
                            <li class="pb-2"><i class="fa-solid fa-mobile"> </i> <a href="tel:+92 313 7709109"
                                    class="text-decoration-none text-muted">+92 313 7709109</a></li>
                            <li class="pb-2"><i class="fa-brands fa-whatsapp"> </i> <a href="tel:+92 313 7709109"
                                    class="text-decoration-none text-muted">+92 313
                                    7709109</a></li>
                            <li class="pb-2"><i class="fa-solid fa-envelope"> </i> <a
                                    href="mailto:info@herbalbyte.store"
                                    class="text-decoration-none text-muted">info@herbalbyte.store</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-top col-12 pt-5 pb-4">
                    <span class="fst-italic text-muted"> © 2024, Byte Mart Powered by Ecomify .
                        <a href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'privacy_policy']) }}" class="text-decoration-none text-muted privacyPolicy">Privacy policy</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

</section>
<?php
}
?>

