<div>
    {{-- 
        Este componente de edición reutiliza la vista del formulario de creación.
        Livewire conectará los `wire:model` y `wire:submit` a los métodos y propiedades
        de esta clase (EditarUsuario), no a los de CrearUsuario.
    --}}
    @include('livewire.encuesta.usuario.crear-usuario')
</div>
