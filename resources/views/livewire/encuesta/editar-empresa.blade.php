<div>
    {{-- 
        Este componente de edición no necesita su propio HTML de formulario.
        En su lugar, vamos a incluir y reutilizar la vista del formulario de creación.
        Livewire es lo suficientemente inteligente como para saber que, aunque la vista
        es la misma, el componente que la controla es "EditarEmpresa", por lo que
        los `wire:model` y `wire:submit` se conectarán a los métodos y propiedades
        de la clase EditarEmpresa.
    --}}
    @include('livewire.encuesta.crear-empresa')
</div>
