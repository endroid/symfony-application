<template>
    <div>
        <BaseInputText
                v-model="newExampleText"
                placeholder="New example"
                @keydown.enter="addExample"
        />
        <ul v-if="examples.length">
            <Example
                    v-for="example in examples"
                    :key="example.id"
                    :example="example"
                    @remove="removeExample"
            />
        </ul>
        <p v-else>
            Nothing left in the list. Add a new example in the input above.
        </p>
    </div>
</template>

<script>
	import BaseInputText from './BaseInputText.vue';
	import Example from './Example.vue';

	let nextExampleId = 1;

	export default {
		components: {
			BaseInputText,
            Example
		},
		data () {
			return {
				newExampleText: '',
				examples: [
					{
						id: nextExampleId,
						text: 'Example ' + nextExampleId++
					},
					{
						id: nextExampleId,
						text: 'Example ' + nextExampleId++
					},
					{
						id: nextExampleId,
						text: 'Example ' + nextExampleId++
					}
				]
			}
		},
		methods: {
			addExample () {
				const trimmedText = this.newExampleText.trim();
				if (trimmedText) {
					this.examples.push({
						id: nextExampleId++,
						text: trimmedText
					});
					this.newExampleText = ''
				}
			},
			removeExample (idToRemove) {
				this.examples = this.examples.filter(example => {
					return example.id !== idToRemove
				})
			}
		}
	}
</script>
