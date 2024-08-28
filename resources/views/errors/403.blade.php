@extends('layouts.errors')

@section('titulo', __('Prohibido'))
@section('codigo', '403')
@section('mensaje', __($exception->getMessage() ?: 'Prohibido'))
