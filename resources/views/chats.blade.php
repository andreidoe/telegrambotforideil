@extends('layouts.app')

	<table>
	<tr>
		<th width="80">Chat ID</th>			
		<th width="120">Username</th>
		<th width="50">Status</th>
		<th><form action="/add">
					<button type="submit">Refresh</button>
				</form>
			</th>
	</tr>

	<?php foreach ($chats as $chat): ?> 
		<tr>
			<td width="120">{{$chat->id}}</td>
			<td width="150">{{$chat->username}}</td>
			<td width="150">{{$chat->status}}</td>
			<td width="80">
				<form action="/chat/{{$chat->id}}">
					<button type="submit">Go to</button>
				</form>
			</td>
			<td width="180"> 
				<?php if ($chat->status = 1): ?>
					<form action="/chat/{{$chat->id}}/deactivate"><button>Deactivate</button></form>
				<?php else: ?>
					
				<?php endif ?>
			</td>
			<td width="80">
				<form action="/chat/{{$chat->id}}/delete">
					<button type="submit">Delete</button>
				</form>
			</td>
		</tr>
	<?php endforeach ?>
</table>
