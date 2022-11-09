<div class="text-end">
    <a class="btn btn-sm" href="{{route('admin.users.edit', $id)}}">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" class="btn btn-danger btn-sm remove" onclick="callDeleteAlert('{{$id}}');">
        <i class="fa fa-trash"></i>
    </button>
</div>
