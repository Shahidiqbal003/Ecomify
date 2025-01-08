<form class="needs-validation" novalidate action="{{ Route('store.contact.submit', ['shop' => request()->route('shop')]) }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <input type="text" name="name" class="form-control p-3 rounded-0" placeholder="Name" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <input type="email" name="email" class="form-control p-3 rounded-0" placeholder="Email" required>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <input type="text" name="phone" class="form-control p-3 rounded-0" placeholder="Phone Number" required>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <textarea name="comment" class="form-control rounded-0" rows="4" placeholder="Comment"></textarea>
        </div>
        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-dark pb-2 pe-4 ps-4 pt-2 rounded-0">Submit</button>
        </div>
    </div>
</form>

