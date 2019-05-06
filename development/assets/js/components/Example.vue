<template>
    <li>
        {{ example.text }}
        <button @click="$emit('remove', example.id)">
            X
        </button>
    </li>
</template>

<script>
	export default {
		props: {
			example: {
				type: Object,
				required: true
			}
		}
	}
</script>