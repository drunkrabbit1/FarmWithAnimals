<script setup>
defineProps({
    color: String,
});
</script>

<template>
    <button class="plus-button plus-button-radius relative flex justify-center items-center bg-white border focus:outline-none shadow
                    text-gray-600 rounded focus:ring ring-gray-200 group">
                        <span class="absolute hidden group-focus:block left- min-w-full w-max bg-white shadow-md mt-1 rounded">
                            <div class="grid grid-flow-col auto-cols-auto">
                                <slot />
                            </div>
                        </span>
    </button>
</template>
