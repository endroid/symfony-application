<template>
    <li>
        {{ user.email }}
        <button @click="$emit('remove', user.id)">
            X
        </button>
    </li>
</template>

<script>
	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		}
	}
</script>