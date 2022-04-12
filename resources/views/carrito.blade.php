@extends('layouts.master')

@section('content')
    <br>
    <div class="container-fluid">
      <section class="section mb-2 mt-5">
        <div class="card card-ecommerce">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table product-table">
                <thead class="mdb-color lighten-5">
                  <tr>
                    <th>Imagen</th>
                    <th class="font-weight-bold">
                      <strong>Producto</strong>
                    </th>
                    <th></th>
                    <th class="font-weight-bold">
                      <strong>Precio</strong>
                    </th>
                    <th class="font-weight-bold">
                      <strong>Cantidad</strong>
                    </th>
                    <th class="font-weight-bold">
                      <strong>STotal</strong>
                    </th>
                    <th>Elimnar</th>
                  </tr>
                </thead>
                <tbody>

                  <tr>

                    <th scope="row">
                      <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/13.jpg" alt=""
                        class="img-fluid z-depth-0">
                    </th>
                    <td>

                      <h5 class="mt-3">

                        <strong>iPhone</strong>

                      </h5>

                      <p class="text-muted">Apple</p>

                    </td>



                    <td></td>

                    <td>$800</td>

                    <td class="text-center text-md-left">

                      <span class="qty">1 </span>

                      <div class="btn-group radio-group ml-2" data-toggle="buttons">

                        <label class="btn btn-sm btn-primary btn-rounded">

                          <input type="radio" name="options" id="option1">&mdash;

                        </label>

                        <label class="btn btn-sm btn-primary btn-rounded">

                          <input type="radio" name="options" id="option2">+

                        </label>

                      </div>

                    </td>

                    <td class="font-weight-bold">

                      <strong>$800</strong>

                    </td>

                    <td>

                      <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"
                        title="Remove item">X

                      </button>

                    </td>

                  </tr>


                  <!-- Fourth row -->
                  <tr>
                    <td colspan="2"></td>
                    <td>
                      <h4 class="mt-2">
                        <strong>Total</strong>
                      </h4>
                    </td>
                    <td class="text-right">
                      <h4 class="mt-2">
                        <strong>$2600</strong>
                      </h4>
                    </td>
                    <td colspan="3" class="text-right">
                      <a type="button" href="page/pasarela" class="btn btn-primary btn-rounded">Pagar
                        <i class="fas fa-angle-right right"></i>
                      </a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection
