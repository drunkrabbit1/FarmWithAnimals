<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AddAnimalButton from '@/Components/Game/AddAnimalButton.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    animals: Array,
    farm: {},
});

const formAnimalAdding = useForm({
    id: null
})

const postAddingAnimal = (id) => {
    Inertia.post(route('game.animals.adding'), {
        'id': id
    })
}
</script>

<template>
    <AppLayout title="Dashboard" :backgroundStyle="'background: linear-gradient(180deg, #E0F7FA 0%, #80DEEA 100%);'">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <div class="pt-4 container">
                    <AddAnimalButton>
                        <div v-for="animal in props.animals" class="p-2">
                            <img class="w-8"
                                 :class="[animal.selected ? 'bw' : '']"
                                 :src="animal.avatar"
                                 @click="animal.selected ? undefined : this.postAddingAnimal(animal.id)">
                        </div>
                    </AddAnimalButton>
                </div>
                <div class="pt-7 max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="container mx-auto ">
                        <div class="grid grid-flow-col auto-cols-auto items-center gap-4 text-center justify-center justify-items-center content-center">
                            <div v-for="farm_animal in props.farm.animals" class="" :id="'animal-'+farm_animal.pivot.id">
                                <img
                                    :style="'width: '+this.getSizeAvatar(farm_animal)+'rem'"
                                    :src="farm_animal.avatar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </AppLayout>
</template>

<script>
    export default {
        data() {
            return {
                farm_animal_list: [],
            }
        },
        mounted() {
            console.log('dasdadas');
            let user = this.$attrs.user;
            window.Echo.channel(user.email + user.id)
                .listen('AnimalDevEvent', (animal_list) => {
                    this.farm_animal_list = animal_list;
                })
                .listen('AnimalRemoveEvent', (animal) => {
                    let animal_div_id = 'animal-' + animal.id;
                    this.$inertia.reload();
                    document.getElementById(animal_div_id).remove();
                });
        },
        methods: {
            getSizeAvatar(animal) {
                let farm_animal = this.farm_animal_list
                    .find(farm_animal => farm_animal.id === animal.pivot.id);
                let size = animal.size;

                if (farm_animal !== undefined) {
                    size = farm_animal.size
                }

                return size / 2 + 3;
            }
        }
    }
</script>
