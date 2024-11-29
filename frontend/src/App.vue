<template>
	<div class="flex justify-center p-3">
		<div class="flex">
			<RouterLink to="/" class="p-2">
				<span class="text-xl font-bold">Frontend</span>
			</RouterLink>
			<RouterLink to="/add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
				Add User
			</RouterLink>
		</div>
	</div>
	<main>
		<RouterView />
	</main>
</template>