
@extends('layouts.app')

	<table>
		<tr>
			<th width="120" align="center">Username</th>
			<th width="400" align="center">Text</th>
			<th width="150" align="center">Date</th>
			<th>
				<form action="/add">
					<button type="submit">Refresh</button>
				</form>
			</th>
		</tr>
	<?php foreach ($messages as $message): ?> 
		<tr>
			<td width="120" align="center">{{$message->username}}</td>
			<td width="400" align="center">{{$message->text}}</td>
			<td width="150" align="center">{{$message->date}}</td>
		</tr>
	<?php endforeach ?>
</table>

<form action="/chat/{{$chatId}}/send" class="form-signin" method="post">
	{{ csrf_field() }}
	<h3 class="form-signin-heading">Send Message</h3>
	<label for="inputText" class="sr-only">Message</label>
	<br />
	<textarea name="message" type="text" id="inputText" class="form-control" placeholder="Message" required autofocus></textarea>
	<br />
	<button class="btn btn-lg btn-primary btn-block" type="submit">Send Message</button>
</form>
