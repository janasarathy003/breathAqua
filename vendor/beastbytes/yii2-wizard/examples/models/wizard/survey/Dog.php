<?php
namespace beastbytes\wizard\models\wizard\survey;

class Dog extends CatDog
{
    protected $breeds = [
        'Affenpinscher',
        'Afghan Hound',
        'Airedale Terrier',
        'Akita',
        'Alaskan Malamute',
        'American Cocker Spaniel',
        'American Water Spaniel',
        'Anatolian Shepherd Dog',
        'Australian Cattle Dog',
        'Australian Shepherd',
        'Australian Silky Terrier',
        'Australian Terrier',
        'Azawakh',
        'Basenji',
        'Basset Bleu de Gascogne',
        'Basset Fauve de Bretagne',
        'Basset Griffon Vendeeen Grand',
        'Basset Griffon Vendeen Petit',
        'Basset Hound',
        'Bavarian Mountain Hound',
        'Beagle',
        'Bearded Collie',
        'Beauceron',
        'Bedlington Terrier',
        'Belgian Shepherd Dog Groenendael',
        'Belgian Shepherd Dog Laekenois',
        'Belgian Shepherd Dog Malinois',
        'Belgian Shepherd Dog Tervueren',
        'Bergamasco',
        'Bernese Mountain Dog',
        'Bichon Frise',
        'Black Russian Terrier',
        'Bloodhound',
        'Boerboel',
        'Bolognese',
        'Border Collie',
        'Border Terrier',
        'Borzoi',
        'Boston Terrier',
        'Bouvier des Flandres',
        'Boxer',
        'Bracco Italiano',
        'Briard',
        'Brittany',
        'Bull Terrier',
        'Bulldog',
        'Bullmastiff',
        'Cairn Terrier',
        'Canaan Dog',
        'Canadian Eskimo Dog',
        'Cane Corso',
        'Cardigan Welsh Corgi',
        'Catalan Sheepdog',
        'Cavalier King Charles Spaniel',
        'Cesky Terrier',
        'Chart Polski',
        'Chesapeake Bay Retriever',
        'Chihuahua',
        'Chinese Crested Dog',
        'Chippiparai',
        'Chow Chow',
        "Cirneco dell'Etna",
        'Clumber Spaniel',
        'Coton de Tulear',
        'Curly Coated Retriever',
        'Dachshund',
        'Dalmatian',
        'Dandie Dinmont Terrier',
        'Deerhound',
        'Dobermann Pinscher',
        'Dogue De Bordeaux',
        'Elkhound',
        'English Cocker Spaniel',
        'English Setter',
        'English Springer Spaniel',
        'English Toy Terrier',
        'Entlebucher Mountain Dog',
        'Estrela Mountain Dog',
        'Eurasier',
        'Field Spaniel',
        'Finnish Lapphund',
        'Finnish Spitz',
        'Flat Coated Retriever',
        'Foxhound',
        'French Bulldog',
        'Galgo Espa??ol',
        'German Longhaired Pointer',
        'German Pinscher',
        'German Shepherd Dog',
        'German Shorthaired Pointer',
        'German Spitz (Klein)',
        'German Spitz (Mittel)',
        'German Wirehaired Pointer',
        'Giant Schnauzer',
        'Glen of Imaal Terrier',
        'Golden Retriever',
        'Gordon Setter',
        'Grand Bleu de Gascogne',
        'Great Dane',
        'Greenland Dog',
        'Greyhound',
        'Griffon Bruxellios',
        'Hamiltonstovare',
        'Havanese',
        'Hortaya Borzaya',
        'Hovawart',
        'Hungarian Kuvasz',
        'Hungarian Puli',
        'Hungarian Vizsla',
        'Hungarian Wirehaired Vizsla',
        'Ibizan Hound',
        'Irish Red and White Setter',
        'Irish Setter',
        'Irish Terrier',
        'Irish Water Spaniel',
        'Irish Wolfhound',
        'Italian Greyhound',
        'Italian Spinone',
        'Jack Russell Terrier',
        'Japanese Akita Inu',
        'Japanese Chin',
        'Japanese Shiba Inu',
        'Japanese Spitz',
        'Keeshond',
        'Kerry Blue Terrier',
        'King Charles Spaniel',
        'Komondor',
        'Kooikerhondje',
        'Korean Jindo',
        'Labrador Retriever',
        'Lagotto Romagnolo',
        'Lakeland Terrier',
        'Lancashire Heeler',
        'Large Munsterlander',
        'Leonberger',
        'Lhasa Apso',
        'Lowchen',
        'Lurcher',
        'Magyar ag??r',
        'Maltese',
        'Manchester Terrier',
        'Maremma Sheepdog',
        'Mastiff',
        'Mexican Hairless',
        'Miniature Bull Terrier',
        'Miniature Pinscher',
        'Miniature Poodle',
        'Miniature Schnauzer',
        'Mixed (Cross or Mongrel)',
        'Neapolitan Mastiff',
        'Newfoundland',
        'Norfolk Terrier',
        'Northern Inuit',
        'Norwegian Buhund',
        'Norwegian Elkhound',
        'Norwegian Lundehund',
        'Norwich Terrier',
        'Nova Scotia Duck-Tolling Retriever',
        'Old English Sheepdog',
        'Otterhound',
        'Padenco',
        'Papillon',
        'Parson Russell Terrier',
        'Pekingese',
        'Pembroke Welsh Corgi',
        'Pharaoh Hound',
        'Pointer',
        'Polish Lowland Sheepdog',
        'Pomeranian',
        'Poodle (Standard)',
        'Portuguese Podengo',
        'Portugese Water Dog',
        'Pug',
        'Pyrenean Mastiff',
        'Pyrenean Mountain Dog',
        'Pyrenean Sheepdog',
        'Rhodesian Ridgeback',
        'Rottweiler',
        'Rough Collie',
        'Saluki',
        'Samoyed',
        'Schipperke',
        'Schnauzer',
        'Scottish Terrier',
        'Sealyham Terrier',
        'Segugio Italiano',
        'Shar Pei',
        'Shetland Sheepdog',
        'Shih Tzu',
        'Siberian Husky',
        'Silken Windhound',
        'Skye Terrier',
        'Sloughi',
        'Smooth Collie',
        'Smooth Fox Terrier',
        'Soft Coated Wheaten Terrier',
        'Spanish Water Dog',
        'St. Bernard',
        'Staffordshire Bull Terrier',
        'Sussex Spaniel',
        'Swedish Lapphund',
        'Swedish Vallhund',
        'Tamaskan',
        'Tibetan Mastiff',
        'Tibetan Spaniel',
        'Tibetan Terrier',
        'Toy Poodle',
        'Traditional Shar Pei',
        'Weimaraner',
        'Welsh Springer Spaniel',
        'Welsh Terrier',
        'West Highland White Terrier',
        'Whippet',
        'Wire Fox Terrier',
        'Yorkshire Terrier'
    ];
}
