<div class="row g-3">
    <div class="col-md-4 mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name"
               value="{{old('name', $food->name)}}">
    </div>

    <div class="col-md-4 mb-3">
        <label for="units" class="form-label">Units</label>
        <input type="text" class="form-control" id="units" name="units"
               value="{{old('units', $food->units)}}">
    </div>

    <div class="col-md-4 mb-3">
        <label for="type" class="form-label">Type</label>
        <input type="text" class="form-control" id="type" name="type"
               value="{{old('type', $food->type)}}">
    </div>

</div>
<div class="row g-3">
    <div class="col-md-4 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock"
               value="{{old('stock', $food->stock)}}">
    </div>

</div>
