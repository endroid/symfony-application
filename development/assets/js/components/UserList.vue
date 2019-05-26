<template>
    <div>
        <BaseInputText
                v-model="newUserEmail"
                placeholder="New user"
                @keydown.enter="addUser"
        />
        <ul v-if="users.length">
            <User
                    v-for="user in users"
                    :key="user.id"
                    :user="user"
                    @remove="removeUser"
            />
        </ul>
        <p v-else>
            Nothing left in the list. Add a new user in the input above.
        </p>
    </div>
</template>

<script>
	import BaseInputText from './BaseInputText.vue';
	import User from './User.vue';

	let nextUserId = 1;

	export default {
		components: {
			BaseInputText,
            User
		},
		data () {
			return {
				newUserEmail: '',
				users: [
					{
						id: nextUserId,
						email: 'user_' + nextUserId++ + '@endroid.nl'
					},
					{
						id: nextUserId,
						email: 'user_' + nextUserId++ + '@endroid.nl'
					},
					{
						id: nextUserId,
						email: 'user_' + nextUserId++ + '@endroid.nl'
					}
				]
			}
		},
		methods: {
			addUser () {
				const trimmedText = this.newUserEmail.trim();
				if (trimmedText) {
					this.users.push({
						id: nextUserId++,
						email: trimmedText
					});
					this.newUserEmail = ''
				}
			},
			removeUser (idToRemove) {
				this.users = this.users.filter(user => {
					return user.id !== idToRemove
				})
			}
		}
	}
</script>
