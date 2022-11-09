<div class="row g-3">
    <div class="col-md-4 mb-3">
        <label for="firstname" class="form-label">Firstname</label>
        <input type="text" class="form-control" id="firstname" name="firstname"
               value="{{old('firstname', $user->firstname)}}">
    </div>

    <div class="col-md-4 mb-3">
        <label for="lastname" class="form-label">Lastname</label>
        <input type="text" class="form-control" id="lastname" name="lastname"
               value="{{old('lastname', $user->lastname)}}">
    </div>

    <div class="col-md-4 mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone"
               value="{{old('phone', $user->phone)}}">
    </div>

</div>
<div class="row g-3">
    <div class="col-md-4 mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email"
               value="{{old('email', $user->email)}}">
    </div>

    <div class="col-md-4 mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="col-md-4 mb-3">
        <label for="password_confirmation" class="form-label">Password confirmation</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
</div>
