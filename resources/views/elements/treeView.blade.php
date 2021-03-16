@foreach($items as $item)
<li>
    <span class="folder-data">
        <span class="folder-name">
            {{ $item->{$text} }}
        </span>
        <span class="folder-icons">
            @if($files)
            <i class="fas fa-archive folder-icon text-info tooltip-wrap" onClick="{{ $functions['files'] }}({{ $item->id }})">
                <span class="tooltip-content top info">Ver Archivos</span>
            </i>
            @endif
            @if($admin)
            <i class="fas fa-folder-plus folder-icon text-success tooltip-wrap" onClick="{{ $functions['add'] }}({{ $item->id }})">
                <span class="tooltip-content top success">Agregar Carpeta</span>
            </i>
            <i class="fas fa-edit folder-icon text-warning tooltip-wrap" onClick="{{ $functions['edit'] }}({{ $item->id }})">
                <span class="tooltip-content top warning">Editar Nombre</span>
            </i>
            @if(!is_null($item->parentFolder))
            @if(count($item->files) == 0 && count($item->childrenFolders) == 0)
            <i class="fas fa-trash folder-icon text-danger tooltip-wrap" onClick="{{ $functions['delete'] }}({{$item->id }}, 'Carpeta {{$item->name}}', '{{$fun}}')">
                <span class="tooltip-content top danger">Eliminar Carpeta</span>
            </i>
            @endif
            @endif
            @endif
        </span>
    </span>
    @if(count($item->children) > 0)
    <ul>
        @include('elements.treeView', ['items' => $item->children, 'text' => $text, 'files' => $files, 'admin' => $admin, 'functions' => $functions])
    </ul>
    @endif
</li>
@endforeach
