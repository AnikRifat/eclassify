<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Area
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $state_id
 * @property string|null $state_code
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|Area filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 */
	class Area extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlockUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $blocked_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser whereBlockedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockUser whereUserId($value)
 */
	class BlockUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $image
 * @property string|null $tags
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereViews($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $sequence
 * @property string $name
 * @property string $image
 * @property int|null $parent_category_id
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $approved_items
 * @property-read int|null $approved_items_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomFieldCategory> $custom_fields
 * @property-read int|null $custom_fields_count
 * @property-read mixed $translated_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Category|null $parent
 * @property-read \App\Models\Slider|null $slider
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Category> $subcategories
 * @property-read int|null $subcategories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CategoryTranslation> $translations
 * @property-read int|null $translations_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\Category|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Category[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category search($search)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereDescription($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereImage($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereName($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereParentCategoryId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereSequence($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereSlug($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereStatus($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property int $language_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereUpdatedAt($value)
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $sender_id
 * @property int $item_offer_id
 * @property string|null $message
 * @property string|null $file
 * @property string|null $audio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $message_type
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereAudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereItemOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property string $state_code
 * @property int $country_id
 * @property string $country_code
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $flag
 * @property string|null $wikiDataId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|City filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|City sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereWikiDataId($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContactUs
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereUpdatedAt($value)
 */
	class ContactUs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string|null $iso3
 * @property string|null $numeric_code
 * @property string|null $iso2
 * @property string|null $phonecode
 * @property string|null $capital
 * @property string|null $currency
 * @property string|null $currency_name
 * @property string|null $currency_symbol
 * @property string|null $tld
 * @property string|null $native
 * @property string|null $region
 * @property int|null $region_id
 * @property string|null $subregion
 * @property int|null $subregion_id
 * @property string|null $nationality
 * @property string|null $timezones
 * @property string|null $translations
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $emoji
 * @property string|null $emojiU
 * @property int|null $flag
 * @property string|null $wikiDataId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCurrencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCurrencySymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereEmojiU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNumericCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePhonecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereSubregion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereSubregionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTimezones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTranslations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereWikiDataId($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomField
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $image
 * @property int $required
 * @property string|null $values
 * @property int|null $min_length
 * @property int|null $max_length
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomFieldCategory> $custom_field_category
 * @property-read int|null $custom_field_category_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ItemCustomFieldValue> $item_custom_field_values
 * @property-read int|null $item_custom_field_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereMaxLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereMinLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomField whereValues($value)
 */
	class CustomField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomFieldCategory
 *
 * @method static upsert(null[] $array, array $customFieldCategory)
 * @property int $id
 * @property int $category_id
 * @property int $custom_field_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\CustomField|null $custom_fields
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory whereCustomFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomFieldCategory whereUpdatedAt($value)
 */
	class CustomFieldCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Faq
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUpdatedAt($value)
 */
	class Faq extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Favourite
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $item_id
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereUserId($value)
 */
	class Favourite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FeatureSection
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $sequence
 * @property string $filter
 * @property string|null $value
 * @property string $style
 * @property int|null $min_price
 * @property int|null $max_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereMaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureSection whereValue($value)
 */
	class FeatureSection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FeaturedItems
 *
 * @property int $id
 * @property string $start_date
 * @property string|null $end_date
 * @property int $item_id
 * @property int $package_id
 * @property int $user_purchased_package_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems onlyActive()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedItems whereUserPurchasedPackageId($value)
 */
	class FeaturedItems extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Item
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property float $price
 * @property string $image
 * @property string|null $watermark_image
 * @property float $latitude
 * @property float $longitude
 * @property string $address
 * @property string $contact
 * @property bool $show_only_to_premium
 * @property string $status
 * @property bool $active
 * @property string|null $rejected_reason
 * @property string|null $video_link
 * @property string $city
 * @property string|null $state
 * @property string $country
 * @property int|null $area_id
 * @property int $user_id
 * @property int $category_id
 * @property string|null $all_category_ids
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomField> $custom_fields
 * @property-read int|null $custom_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favourite> $favourites
 * @property-read int|null $favourites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FeaturedItems> $featured_items
 * @property-read int|null $featured_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ItemImages> $gallery_images
 * @property-read int|null $gallery_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ItemCustomFieldValue> $item_custom_field_values
 * @property-read int|null $item_custom_field_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ItemOffer> $item_offers
 * @property-read int|null $item_offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slider> $sliders
 * @property-read int|null $sliders_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserReports> $user_reports
 * @property-read int|null $user_reports_count
 * @method static \Illuminate\Database\Eloquent\Builder|Item approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Item filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item notOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyNonBlockedUsers()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item owner()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Item sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereAllCategoryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereRejectedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereShowOnlyToPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereWatermarkImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ItemCustomFieldValue
 *
 * @method static create(array $itemCustomFieldValues)
 * @method static insert(array $itemCustomFieldValues)
 * @property int $id
 * @property int $item_id
 * @property int $custom_field_id
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CustomField $custom_field
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereCustomFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCustomFieldValue whereValue($value)
 */
	class ItemCustomFieldValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ItemImages
 *
 * @property int $id
 * @property string $image
 * @property int $item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemImages whereUpdatedAt($value)
 */
	class ItemImages extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ItemOffer
 *
 * @property int $id
 * @property int $seller_id
 * @property int $buyer_id
 * @property int $item_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $buyer
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\User $seller
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer owner()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemOffer whereUpdatedAt($value)
 */
	class ItemOffer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_in_english
 * @property string $app_file
 * @property string $panel_file
 * @property string $web_file
 * @property int $rtl
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereAppFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereNameInEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language wherePanelFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereRtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereWebFile($value)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notifications
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property string $image
 * @property int|null $item_id
 * @property string $send_to
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereSendTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUserId($value)
 */
	class Notifications extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Package
 *
 * @property int $id
 * @property string $name
 * @property float $final_price
 * @property float $discount_in_percentage
 * @property float $price
 * @property string $duration
 * @property string $item_limit
 * @property string $type
 * @property string $icon
 * @property string $description
 * @property int $status
 * @property string|null $ios_product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserPurchasedPackage> $user_purchased_packages
 * @property-read int|null $user_purchased_packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDiscountInPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereFinalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereIosProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereItemLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentConfiguration
 *
 * @property int $id
 * @property string $payment_method
 * @property string $api_key
 * @property string $secret_key
 * @property string $webhook_secret_key
 * @property string|null $currency_code
 * @property int $status 0 - Disabled, 1 - Enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentConfiguration whereWebhookSecretKey($value)
 */
	class PaymentConfiguration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $payment_gateway
 * @property string|null $order_id order_id / payment_intent_id
 * @property string $payment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUserId($value)
 */
	class PaymentTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReportReason
 *
 * @property int $id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportReason whereUpdatedAt($value)
 */
	class ReportReason extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $image
 * @property string $sequence
 * @property string|null $third_party_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $model_type
 * @property int|null $model_id
 * @property-read \App\Models\Category|null $categories
 * @property-read \App\Models\Item|null $item
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereThirdPartyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 */
	class Slider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialLogin
 *
 * @property int $id
 * @property int $user_id
 * @property string $firebase_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLogin whereUserId($value)
 */
	class SocialLogin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\State
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property string $state_code
 * @property string|null $fips_code
 * @property string|null $iso2
 * @property string|null $type
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $flag
 * @property string|null $wikiDataId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|State filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|State sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereFipsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereWikiDataId($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tip
 *
 * @property int $id
 * @property string $description
 * @property int $sequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $translated_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TipTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tip onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tip search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tip withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tip withoutTrashed()
 */
	class Tip extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TipTranslation
 *
 * @property int $id
 * @property int $tip_id
 * @property int $language_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\Tip $tip
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereTipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipTranslation whereUpdatedAt($value)
 */
	class TipTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $mobile
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $profile
 * @property string|null $type remove in next update
 * @property string $password
 * @property string $fcm_id remove this in next update
 * @property int $notification
 * @property string|null $firebase_id remove in next update
 * @property string|null $address
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $country_code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFcmToken> $fcm_tokens
 * @property-read int|null $fcm_tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserReports> $user_reports
 * @property-read int|null $user_reports_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFcmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserFcmToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $fcm_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFcmToken whereUserId($value)
 */
	class UserFcmToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserPurchasedPackage
 *
 * @property int $id
 * @property int $user_id
 * @property int $package_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $total_limit
 * @property int $used_limit
 * @property int|null $payment_transactions_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PaymentTransaction|null $PaymentTransaction
 * @property-read mixed $remaining_days
 * @property-read mixed $remaining_item_limit
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage onlyActive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage wherePaymentTransactionsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereTotalLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereUsedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchasedPackage whereUserId($value)
 */
	class UserPurchasedPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserReports
 *
 * @property int $id
 * @property int|null $report_reason_id
 * @property int $user_id
 * @property int $item_id
 * @property string|null $other_message
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $status
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\ReportReason|null $report_reason
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports filter($filterObject)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereOtherMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereReportReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReports whereUserId($value)
 */
	class UserReports extends \Eloquent {}
}

