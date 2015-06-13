# KL_GuestWishlist

Save products to a temporary session based wishlist. There is an endpoint available that will respond by
giving you a url that contains all the favourite items so that they can be shared in Social media, like so:

This is the endpoint that will give you the shareable URL:

    https://local.frontmen.com/se//guest-wishlist/item/all

And this is what it will give you:

    https://local.frontmen.com/se/guest-wishlist/?items=["1","2","3"]

Those integers are product ids. Append any existing product id to add it to your current session's guest wishlist