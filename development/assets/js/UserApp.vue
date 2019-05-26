<template>
    <div id="app">
        <h1>User List</h1>
        <UserList/>
    </div>
</template>

<script>
	import UserList from './components/UserList.vue'

	export default {
		components: {
			UserList
		}
	}
</script>
