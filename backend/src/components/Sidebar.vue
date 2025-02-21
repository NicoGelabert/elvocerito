<template>

    <div class="min-w-[160px] w-[25%]  transition-all" id="sideBarContainer" >
        <button id="toggleIconButton" @click="emit('toggle-sidebar', toggleChevronLeftIcon()) " class="flex items-center justify-center rounded transition-colors w-8 h-8 mr-2 text-white bg-black hover:text-black hover:bg-white">
            <div :class="[toggleIconLeft ? 'iconOpen' : 'iconClosed']" >
                <ChevronLeftIcon class="w-6"/>
            </div>
        </button>
        <router-link :to="{name: 'app.dashboard'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm" >
                Dashboard
            </span>
            <span class="mr-2">
                <BuildingStorefrontIcon class="w-5"/>
            </span>
        </router-link>
        <router-link :to="{name: 'app.homeherobanners'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Home Hero Banner
            </span>
            <span class="mr-2">
                <PhotoIcon class="w-5"/>
            </span>
        </router-link>
        <router-link :to="{name: 'app.categories'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Categorías
            </span>
            <span class="mr-2">
                <MegaphoneIcon class="w-5"/>
            </span>
        </router-link>
        <router-link :to="{name: 'app.products'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Anunciantes
            </span>
            <span class="mr-2">
                <ArchiveBoxIcon class="w-5"/>
            </span>
        </router-link>
        <router-link :to="{name: 'app.articles'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Artículos
            </span>
            <span class="mr-2">
                <NewspaperIcon class="w-5"/>
            </span>
        </router-link>
        <router-link :to="{name: 'app.authors'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Autores
            </span>
            <span class="mr-2">
                <IdentificationIcon class="w-5"/>
            </span>
        </router-link>
        <!-- <router-link :to="{name: 'app.alergens'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Alergens
            </span>
            <span class="mr-2">
                <EyeDropperIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'app.services'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Services
            </span>
            <span class="mr-2">
                <BriefcaseIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'app.projects'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Projects
            </span>
            <span class="mr-2">
                <LightBulbIcon class="w-5"/>
            </span>
        </router-link> -->
        <router-link :to="{name: 'app.tags'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Tags
            </span>
            <span class="mr-2">
                <TagIcon class="w-5"/>
            </span>
        </router-link>
        <!-- <router-link :to="{name: 'app.clients'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Clients
            </span>
            <span class="mr-2">
                <TrophyIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'app.orders'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Orders
            </span>
            <span class="mr-2">
                <ClipboardDocumentListIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'app.users'}"
                    class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Users
            </span>
            <span class="mr-2">
                <UsersIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'app.customers'}"
        class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Customers
            </span>
            <span class="mr-2">
                <UserGroupIcon class="w-5"/>
            </span>
        </router-link> -->
        <!-- <router-link :to="{name: 'reports'}"
                 class="flex items-center justify-between p-2 gap-8 rounded transition-colors hover:bg-white">
            <span class="text-sm">
                Reports
            </span>
            <span class="mr-2">
                <PresentationChartLineIcon class="w-5"/>
            </span>
        </router-link> -->
    </div>
  
</template>

<script setup>

import {ArchiveBoxIcon,
        BriefcaseIcon,
        BuildingStorefrontIcon,
        ChevronLeftIcon,
        ClipboardDocumentListIcon,
        CurrencyEuroIcon,
        EyeDropperIcon,
        IdentificationIcon,
        LightBulbIcon,
        MegaphoneIcon,
        NewspaperIcon,
        PhotoIcon,
        PresentationChartLineIcon,
        TagIcon,
        TrophyIcon,
        UserGroupIcon,
        UsersIcon,
        } from '@heroicons/vue/24/outline'
import {ref} from "vue";

const emit = defineEmits(['toggle-sidebar'])

const toggleIconLeft = ref(true);
const toggleChevronLeftIcon = () => {
  toggleIconLeft.value = !toggleIconLeft.value;
}

</script>

<style scoped lang="scss">

#sideBarContainer{
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap:1rem;
  padding: 2rem 0 0 2rem ;
  a{
    width: 100%;    
  }
}
.iconOpen{
  transform: rotate(0);
  transition: transform 0.25s cubic-bezier(0.79, 0.33, 0.14, 0.53);
}
.iconClosed{
  transform: rotate(180deg);
  transition: transform 0.25s cubic-bezier(0.79, 0.33, 0.14, 0.53);
}
</style>