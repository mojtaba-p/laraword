<div x-data="notificationsData()" x-init="notificationsInit()">
    <x-dropdown width="w-96" class="ml-auto">
        <x-slot name="trigger">
            <div class="inline-flex mt-5">
                <span class="absolute inline-flex rounded-full h-1 w-1 bg-cyan-500 "
                      x-show="notifications.length > 0"></span>
                <button>
                    <x-svg.bell class="w-6 h-6"/>
                </button>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="p-3 text-gray-500 text-center" x-show="notifications.length < 1">You don't have any
                notification.
            </div>
            <template x-for="notification in notifications">
                <x-dropdown-link x-bind:href="notification.url">
                                    <span class="font-black block" x-text="notification.message">

                                    </span>

                    <span x-text="notification.content"></span>
                </x-dropdown-link>
            </template>
        </x-slot>
    </x-dropdown>
</div>
<script>
    function notificationsData() {
        return {
            notifications: '',
            notificationsInit() {
                fetch('{{ route('dashboard.notifications.index') }}', {headers:{accept:'application/json'}})
                    .then(response => response.json().then(response => this.notifications = response.data))
                setInterval(() =>
                        fetch('{{ route('dashboard.notifications.index') }}', {headers:{accept:'application/json'}})
                            .then(response => response.json().then(response => this.notifications = response.data))
                    , 20000)
            },
        }
    }
</script>
