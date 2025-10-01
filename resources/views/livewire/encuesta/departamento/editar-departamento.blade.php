<div>
    {{-- 
        Este componente de edición reutiliza la vista del formulario de creación.
        Livewire es lo suficientemente inteligente como para vincular los `wire:model`
        y el `wire:submit` a los métodos y propiedades de esta clase (EditarDepartamento),
        no a los de CrearDepartamento.
    --}}
    @include('livewire.encuesta.departamento.crear-departamento')
</div>
