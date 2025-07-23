<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\QuizQuestion;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Dr. Graeme Sait as the instructor
        $graeme = Instructor::create([
            'name' => 'Dr. Graeme Sait',
            'title' => 'Soil Health Expert & Nutrition Farming® Pioneer',
            'bio' => 'World-renowned soil health expert with over 30 years of experience in sustainable agriculture. Founder of Nutri-Tech Solutions and pioneer of Nutrition Farming® methodology.',
            'email' => 'graeme@nutri-tech.com.au',
            'website' => 'https://nutri-tech.com.au',
            'avatar' => '/how-to-thumbnails-languages/graeme_sait_clips.png',
            'specializations' => ['Soil Health', 'Plant Nutrition', 'Sustainable Agriculture', 'Nutrition Farming®'],
            'experience_years' => 35,
            'location' => 'Australia',
            'social_links' => [
                'linkedin' => 'https://linkedin.com/in/graeme-sait',
                'twitter' => 'https://twitter.com/graemesait',
                'website' => 'https://nutri-tech.com.au'
            ]
        ]);

        // Create the Soil Testing Mastery Course
        $course = Course::create([
            'title' => 'Soil Testing Mastery: Foundations of Nutrition Farming®',
            'description' => 'Master the art of soil testing and unlock the hidden language of your soil. This comprehensive course teaches you how to read, interpret, and act on soil test results to build more resilient, profitable, and sustainable farming systems. Learn from Dr. Graeme Sait, pioneer of Nutrition Farming®, as he guides you through four powerful chapters covering everything from basic soil chemistry to advanced mineral ratio management.',
            'category' => 'soil-health',
            'level' => 'intermediate',
            'type' => 'mixed',
            'price' => 0,
            'cover_image' => '/how-to-thumbnails-languages/grow-courses.jpeg',
            'tags' => ['soil testing', 'nutrition farming', 'soil health', 'mineral ratios', 'sustainable agriculture'],
            'status' => 'published',
            'instructor_id' => $graeme->id,
            'duration_hours' => 2,
            'featured' => true,
            'certification' => true,
            'lessons_count' => 13,
            'students_count' => 0,
            'rating' => 0,
        ]);

        // Create lessons for the course - 4 chapters with 3 lessons each + 1 final quiz
        $lessons = [
            // Chapter 1: Foundations of Soil Therapy
            [
                'title' => '🎬 Chapter 1 Introduction – Unlocking the Hidden Language of Your Soil',
                'type' => 'reading',
                'duration_minutes' => 5,
                'content' => 'Welcome to Chapter 1, where we begin our journey into understanding the true power of soil testing. This chapter lays the groundwork for everything that follows, with one key message:

📏 **You can\'t manage what you don\'t measure.**
When it comes to soil, your test results are the most powerful decision-making tool you have.

⏳ For decades, conventional agriculture has focused heavily on input-based systems that treat symptoms rather than addressing root causes. The result? Rising costs, increasing chemical dependency, and diminishing returns.

🌿 But there\'s a better way. Nutrition Farming® empowers you to understand your soil, take back control, and make informed choices that benefit the crop, the planet, and your bottom line. And it all starts with a good soil test.

📚 **In this chapter, you\'ll explore essential soil testing concepts such as:**
• ⚡ Cation Exchange Capacity (CEC)
• 🌡️ pH
• ⚖️ Base Saturation
• 🔄 Mineral Ratios

⚠️ You\'ll discover how imbalances in these factors can trigger a cascade of problems that compromise plant health, reduce yields, and increase pest and disease pressure.

🔍 **Two essential visual tools will help you grasp these interactions:**
• 📈 Mulder\'s Chart: Illustrates how minerals interact—both positively and antagonistically
• 🥧 Cation Antagonism Pie Chart: Shows how excesses in one mineral can restrict the uptake of others

💡 This chapter will help you connect scientific data to practical outcomes. Even small mistakes—like applying the wrong lime or blindly following fertiliser advice—can hold you back. More importantly, you\'ll learn how to avoid these pitfalls.

🎯 By the end, soil testing won\'t be a confusing lab report, but a powerful, practical tool that brings clarity and confidence to your farming decisions.',
                'order' => 1
            ],
            [
                'title' => '🎥 Watch the Video',
                'type' => 'video',
                'duration_minutes' => 20,
                'content' => ' ',
                'order' => 2
            ],
            [
                'title' => '📝 Detailed Summary',
                'type' => 'reading',
                'duration_minutes' => 5,
                'content' => 'I always start with the principle that underpins all of Nutrition Farming®: solve problems at the source. Instead of using synthetic chemicals to suppress symptoms like pests or disease, we must identify and address the mineral or biological causes behind them.

There is concerning data showing that chemical use has increased globally every year for decades, while pest and disease pressure has also risen—clear evidence that the current model is broken.

🔄 **The Interplay: Minerals, Microbes, and Humus**
At the core of this framework are three interconnected elements:
• Minerals – the building blocks of soil fertility
• Microbes – the life forms that cycle those minerals
• Humus – the organic carbon sponge that retains nutrients and moisture

While all three are essential, this series focuses heavily on minerals and how to interpret their presence, absence, and balance through a soil test.

🧪 **What Makes a Good Soil Test?**
A useful soil test should include:
• Base Saturation Percentages – showing how calcium, magnesium, potassium, and sodium are held on the soil colloid
• Cation Exchange Capacity (CEC) – indicating the soil\'s storage capacity for nutrients
• Key Ratios like calcium to magnesium
• Total Exchange Capacity (TEC) – especially important for acidic soils

Labs like AEL in Australia offer this data, but any reputable lab that includes TEC is acceptable.

📉 **Common Mistakes to Avoid**
• Overapplying calcium – can shut down seven other minerals, including phosphate and boron
• Using dolomite in high-magnesium soils – increases compaction and restricts oxygen
• Applying potassium when levels are already high – can reduce calcium uptake and weaken cell strength, increasing disease pressure
• Trusting fertiliser advice blindly – if you don\'t understand your soil test, you risk being misled by input suppliers

📊 **Visual Tools: Mulder\'s Chart & Cation Antagonism Pie Chart**
Two essential tools help bring clarity:
• Mulder\'s Chart – a web of arrows showing which minerals stimulate or antagonise others
*Example: calcium stimulates phosphate, zinc, boron—but excess calcium antagonises them all.*
• Cation Antagonism Pie Chart – illustrates how cations in excess (e.g., potassium, magnesium, sodium) can suppress others
👉 Tip: Print and laminate these charts to keep in your office or shed as ongoing references.

⚖️ **Balance Over Quantity**
It\'s not about how much of a mineral you have—it\'s about how well they work together:
• Calcium is essential, but more isn\'t always better
• Phosphate might be present, but if pH or other minerals are off, it may not be available
• pH is a master variable that controls the availability of all nutrients

🌡️ **The Role of pH in Nutrient Uptake**
Here\'s what the pH-nutrient availability chart shows:
• Ideal soil pH = 6.4
• Low pH (~5.0) limits nitrogen, phosphorus, calcium, and more
• High pH (8.5+) locks out iron, zinc, manganese, boron
✅ Foliar feeding can bypass high or low pH and deliver trace minerals directly to the leaf—up to 12 times more efficiently than soil applications.

⚡ **Cations vs Anions: The Chemistry of Soil**
• Cations: Positively charged (Ca²⁺, Mg²⁺, K⁺, Na⁺)
• Anions: Negatively charged (NO₃⁻, PO₄³⁻, SO₄²⁻)

This distinction helps explain:
• Why anions like nitrate leach more easily
• Why cations are held on the soil colloid
• Why humus, which holds anions, is such a valuable storage bank

📌 **Key Takeaways**
• Soil testing is the most empowering tool in your agronomic toolbox
• Understanding mineral ratios and interactions is more important than chasing raw numbers
• pH and base saturation are crucial concepts for managing nutrient availability
• Use Mulder\'s Chart and the Cation Pie Chart to visualise interactions
• Foliar nutrition is a strategic way to correct imbalances quickly and cost-effectively

⏭️ **Up Next: Chapter 2 – Cracking the Code of Your Soil Test**
In the next chapter, we\'ll move from theory into application. You\'ll learn exactly what each line item on your soil test means, how to interpret values like CEC, TEC, conductivity, and pH—and what those numbers actually tell you about your soil\'s health and productivity potential.',
                'order' => 3
            ],

            // Chapter 2: Cracking the Code
            [
                'title' => '🎬 Chapter 2 Introduction – Turning Numbers into Knowledge',
                'type' => 'reading',
                'duration_minutes' => 10,
                'content' => '🌿 Now that you understand the philosophy and purpose behind soil testing, it\'s time to roll up your sleeves and start interpreting the numbers.

In Chapter 2, we\'ll go deeper into the soil test itself—line by line—and demystify the key terms that appear on most commercial soil reports.

If Chapter 1 was about why to test soil, this chapter is all about how to use those results to guide better decisions on the farm.

📋 **You\'ll learn to identify the critical parameters like:**
• Cation Exchange Capacity (CEC) – the "bucket size" of your soil
• Total Exchange Capacity (TEC) – reveals the presence of acidity-driving hydrogen
• Organic Matter – the single greatest predictor of soil productivity
• pH – the gateway to mineral uptake
• Conductivity – your mineral "oomph" level

🔍 **This chapter is rich in practical insights, including:**
• How to measure your own pH and conductivity at home
• How to understand hydrogen\'s impact on nutrient availability
• Why paramagnetism might be a hidden fertility factor in volcanic soils

✅ By the end, you won\'t just understand the terms on your test—you\'ll start to recognize how they influence one another and what actions they suggest.

⏭️ Next: Let\'s start cracking the code of your soil test.',
                'order' => 4
            ],
            [
                'title' => '🎥 Watch the Video',
                'type' => 'video',
                'duration_minutes' => 20,
                'content' => '(insert video)',
                'order' => 5
            ],
            [
                'title' => '📝 Detailed Summary',
                'type' => 'reading',
                'duration_minutes' => 15,
                'content' => '🧮 **1. Cation Exchange Capacity (CEC) – The Soil\'s Storage Tank**
CEC measures the soil\'s ability to store nutrients—specifically cations like calcium, magnesium, potassium, and sodium.
• Heavy clay soils = high CEC (e.g., 40+)
• Light sandy soils = low CEC (e.g., 3–5)
💡 Tip: In low-CEC soils, avoid broadcasting large inputs—spoon-feed nutrients through fertigation or foliar sprays.

⚡ **2. Cation Exchange Process – The Hydrogen Effect**
When a plant absorbs a cation (like calcium), it must release another cation to maintain electrical balance. It doesn\'t give up potassium or magnesium—it releases hydrogen.
• Hydrogen isn\'t a nutrient—it\'s an acidifier.
• More hydrogen = lower pH = fewer beneficial cations held on the colloid.
🌡️ Key Insight: High hydrogen content means the soil is acidic and depleted of base cations. Always measure hydrogen (via TEC).

🧪 **3. TEC vs CEC – The Hidden Acid in the System**
TEC (Total Exchange Capacity) = CEC + hydrogen.
If your test doesn\'t include TEC, you\'re flying blind in acidic soils.
📉 Example: You might think you have perfect balance with 68% calcium and 12% magnesium, but if you have 30% hydrogen and a pH of 5.5, that 68% calcium is really only about 48% in the full picture.
📌 Always choose a test that measures both CEC and TEC.

🧲 **4. Paramagnetism – Energy in the Earth**
Paramagnetism refers to the soil\'s ability to attract and convert atmospheric energy (long-wave radio frequencies) into light energy (biophotons).
• Volcanic soils are naturally high in paramagnetism.
• You can boost fertility by adding basalt crusher dust—affordable and rich in paramagnetic charge.
🧠 Note: Professor Phil Callahan documented how these "antenna-like" soils improve biology and crop performance.

🌡️ **5. pH – The Mineral Gatekeeper**
• Ideal soil pH: 6.4 (also the ideal for plant sap and even cow/human urine)
• Nutrient availability peaks at this level.
• Acidic soils (pH < 5.5): Poor phosphorus, calcium, nitrogen uptake.
• Alkaline soils (pH > 8): Iron, manganese, zinc, boron are locked out.
✅ DIY pH testing: Mix equal parts soil and deionized water, shake, wait 5 minutes, test with a pH strip or probe. Sample multiple paddock zones—pH varies more than you think.

🧬 **6. Organic Matter – The #1 Fertility Indicator**
• Ideal range: 4–7%
• Australian average: ~1.7%
Organic matter:
• Buffers nutrients
• Stores water
• Improves structure
• Holds negatively charged minerals (nitrate, phosphate, sulfate)
📊 Case Study: A National Bank study of 700 Australian farms found that organic matter was the strongest predictor of profitability. Even a 0.15% increase raised land values substantially.
🎯 Key Insight: Improving humus improves profits—and will soon earn carbon credits.

⚡ **7. Conductivity – Do You Have Enough "Oomph"?**
Conductivity (EC) shows nutrient density in solution.
• Measured with an EC meter and deionized water
• Starting point: 0.2 EC for most crops
• Flowering/fruiting: 0.6–0.8 EC
• Avoid >1.0–1.2 EC (salt stress risk)
Potassium is the biggest driver of conductivity. If EC is low, check potassium first.
📌 Always check EC and potassium together when diagnosing crop stagnation.

📌 **Key Takeaways**
• CEC tells you how much your soil can hold—use it to guide your input strategy.
• Always test for hydrogen (TEC) or you risk misinterpreting base saturation.
• Organic matter is the #1 predictor of productivity—track it and build it.
• pH affects everything—know your paddock zones and adjust accordingly.
• Use conductivity to monitor nutrient sufficiency and vigor.
• Don\'t overlook the energetic side of soil—paramagnetism may be the hidden force in high-performing volcanic soils.

⏭️ **Coming Up: Chapter 3 – Working with Real Tests and Real Numbers**
In Chapter 3, we\'ll go even deeper by analyzing actual soil test data. You\'ll see how to:
• Interpret mineral levels (ppm and base saturation)
• Diagnose imbalances
• Plan corrective strategies (foliar sprays, root zone management)
• Work with macro and trace elements
This is where knowledge meets application—don\'t miss it.',
                'order' => 6
            ],

            // Chapter 3: From Data to Decisions
            [
                'title' => '🎬 Chapter 3 Introduction – Where Knowledge Meets the Paddock',
                'type' => 'reading',
                'duration_minutes' => 10,
                'content' => '🌿 Chapter 3 – Working with Real Tests and Real Numbers
In the first two chapters, you explored the principles of Nutrition Farming® and learned the core parameters of soil testing. Now, it\'s time to move into practical application—interpreting actual soil reports to guide decisions with confidence.

🔍 **From Reading to Understanding**
This chapter is all about transforming numbers into insight. You\'ll learn how to look at real test results and not just read them, but understand exactly what they mean for your farm—and what actions to take next.

🧭 **What You\'ll Learn in This Chapter**
• How to analyze base saturation levels and ratios
• How to pinpoint macronutrient and micronutrient deficiencies
• How to identify antagonisms that block nutrient uptake
• How to plan strategic foliar corrections to fast-track results
• How compost and humus can retain nutrients and buffer imbalances

🌾 **Case Studies of Real Soils**
You\'ll walk through examples of challenging soils:
• High in magnesium (tight, poorly oxygenated soils)
• Low in potassium (weak sugar transport and poor fruit quality)
• Overloaded with iron (locking up zinc, manganese, phosphate)
Each case study shows how specific imbalances show up in the paddock—like small, sour fruit, bland flavour, or pest pressure—and exactly how to address them.

💡 **Why This Matters**
More than anything, this chapter reinforces a core principle:
Soil test interpretation isn\'t just about numbers—it\'s about understanding how minerals behave, how they interact, and how to adjust them to support crop health, soil structure, and profitability.

⏭️ **Coming Up Next**
Get ready to dive deeper into:
• Interpreting mineral levels in ppm and base saturation
• Recognizing patterns that indicate chronic issues
• Choosing the right inputs and application methods
• Crafting nutrient management plans based on real data
This is where knowledge meets action—let\'s get started.',
                'order' => 7
            ],
            [
                'title' => '🎥 Watch the Video',
                'type' => 'video',
                'duration_minutes' => 20,
                'content' => '(insert video)',
                'order' => 8
            ],
            [
                'title' => '📝 Detailed Summary',
                'type' => 'reading',
                'duration_minutes' => 15,
                'content' => '🧲 **1. Calcium & Magnesium – The Breathers and the Binders**
Calcium: Large ion with two charges, promotes soil flocculation (opens the soil)
Magnesium: Small ion with two charges, causes compaction (tightens the soil)
💡 High magnesium soils are hard to work, reduce oxygen flow, and require more nitrogen due to poor microbial activity.

📌 If Mg is too high, it\'s antagonistic to nitrogen, potassium, calcium, and overall nutrient mobility.

📊 **2. Base Saturation – The Balancing Act**
Introduced by Dr. William Albrecht, base saturation describes what % of the soil colloid is occupied by:
• Calcium (Ca)
• Magnesium (Mg)
• Potassium (K)
• Sodium (Na)
• Hydrogen (H)

🎯 Ideal base saturation for medium soils:
• Calcium: 68–70%
• Magnesium: 10–12%
• Potassium: 3–5%
• Sodium: <2%
• Hydrogen: whatever is left (ideally low)

🔁 Calcium + Magnesium should not exceed 80% of the base saturation pie.

📌 This balance affects everything from soil structure to nutrient availability.

⚠️ **3. High Magnesium Case Study – Locked Soil & Tiny Fruit**
Example: Grower has 1247 ppm Mg (ideal ~400), only 114 ppm K (ideal ~400)
Result: A 12:1 Mg:K ratio – a major imbalance
Symptoms: Small, sour grapes; poor sweetness and yield

📉 Solution:
• Foliar spray potassium sulfate with fulvic acid
• Spoon-feed the crop through fertigation
• Possibly apply soft rock phosphate to slowly lift K and P together

💡 **4. Potassium – The Money Mineral**
Drives fruit size, sugar transport, and flavour
• Should be around 3–6% base saturation or 400+ ppm for fruiting crops
• Often suppressed by high Mg or high Na
👉 Low potassium = poor fruit set, bland taste, lower market value

🌿 **5. Humus – The Great Nutrient Keeper**
Negatively charged, humus holds anions like:
• Nitrate (NO₃⁻)
• Sulfate (SO₄²⁻)
• Phosphate (PO₄³⁻)
• Boron (B)

📊 Case Study:
Grower with 6.5% organic matter shows:
• High nitrate (29.7 ppm) without ever applying nitrate fertilisers
• High sulfate (43 ppm)
• Moderate boron (0.7 ppm) despite no boron applications

✅ Proof that humus holds onto leachable nutrients, reducing waste and increasing nutrient efficiency.

🔗 **6. Interactions: Antagonisms & Synergies**
• Magnesium antagonises potassium
• Potassium suppresses calcium and magnesium
• Iron suppresses manganese, zinc, and phosphate
• Zinc affects phosphate, and vice versa
• Copper can affect boron and silica

📌 Even if a nutrient is present, it may not be available due to excesses elsewhere. This is why tissue testing or sap analysis is critical in high-iron or high-calcium soils.

📉 **7. Micronutrient Interpretation**
• Boron: Most leachable trace element; aim for ≥1 ppm
• Zinc: Minimum 5 ppm for healthy cell division and flowering
• Manganese: Affected by iron excess and high pH
• Copper: Often elevated due to fungicide use; ideal 2–3 ppm
• Iron: High iron = red soils, but may lock up other minerals
• Molybdenum: Critical for nitrogen fixation; aim for ≥0.5 ppm

🧪 Molybdenum is required by all nitrogen-fixing organisms (both free-living and nodular). If it\'s missing, you can\'t effectively harness free nitrogen hovering above your crops.

🔧 **Corrective Strategies**
• Use foliar nutrition to bypass antagonisms and pH problems
• Add compost to build humus and hold nutrients longer
• Choose micronised minerals for root zone application in broadacre
• Balance base saturation using lime or gypsum based on needs
• Use ratios to guide both macro and micro mineral decisions

📌 **Key Takeaways**
• Soil test interpretation is about patterns, not just numbers
• Imbalances often explain crop health issues better than simple deficiencies
• Potassium is central to productivity—address it aggressively when low
• Organic matter buffers and enhances nutrient availability—build it!
• Think in ratios: K:Mg, Ca:Mg, Zn:P, Fe:Mn—and always correct accordingly
• Your goal is not just to fix the test—but to unlock plant performance

⏭️ **Next Up: Chapter 4 – Mastering Mineral Ratios and Making Smart Corrections**
In the final chapter, we\'ll uncover the six most important mineral ratios and learn how to use them to guide fertiliser decisions, avoid waste, and correct deficiencies with precision.

You\'ll also learn how to calculate application rates from your test results and combine science with cost-effective practice.

This is where everything clicks—don\'t miss it.',
                'order' => 9
            ],

            // Chapter 4: Mastering Mineral Ratios
            [
                'title' => '🎬 Chapter 4 Introduction – From Theory to Precision Strategy',
                'type' => 'reading',
                'duration_minutes' => 10,
                'content' => '🎯 **Welcome to the Final Chapter: Mastering Mineral Ratios**
At this point, you\'ve learned how to read a soil test, interpret its values, understand the importance of balance, and avoid common pitfalls. Now it\'s time to connect all the dots and develop the skill of building a correction strategy based on mineral ratios—the language of balance and efficiency in the soil.

In this powerful session, you\'ll learn:
• How to calculate the ideal ratio for your soil type
• Which ratios most impact soil breathability, photosynthesis, and nutrient synergy
• How to convert ppm values to kg/ha to create precise fertiliser plans
• When to use lime vs gypsum, micronised inputs, and foliar applications

This chapter isn\'t just academic—it\'s immediately practical. By the end, you\'ll be able to analyze your own soil report, spot the key ratios that need correction, and plan your inputs with confidence and cost-effectiveness.',
                'order' => 10
            ],
            [
                'title' => '🎥 Watch the Video',
                'type' => 'video',
                'duration_minutes' => 20,
                'content' => '(insert video)',
                'order' => 11
            ],
            [
                'title' => '📝 Detailed Summary',
                'type' => 'reading',
                'duration_minutes' => 15,
                'content' => '📐 **1. How to Calculate Inputs from PPM**
Example: You have 2 ppm of zinc, but need 5 ppm.
• That\'s a gap of 3 ppm, or 3 kg/acre of elemental zinc
• Zinc sulfate (monohydrate) is ~33% zinc, so: 3 kg elemental = 9 kg zinc sulfate per acre
• Multiply by 2.5 → 22.5 kg/ha of zinc sulfate
• Same logic applies to copper sulfate (~25% copper), lime (~40% calcium), etc.
💡 Use this simple ppm-to-kilogram method to calculate precise input rates.

⚖️ **2. The Six Most Important Soil Ratios**

a) **Calcium : Magnesium Ratio**
• Controls soil structure and gas exchange
• Calcium flocculates (opens), magnesium compacts (tightens)
• Ideal ratio varies by soil type:
  – Light (sandy): 3:1
  – Medium: 5–6:1
  – Heavy clay: 7:1 or more
📌 Look at base saturation, not ppm, for this ratio.
To fix:
  – Add lime to increase Ca and displace Mg
  – Use gypsum (CaSO₄) to remove Mg via leaching (MgSO₄)

b) **Magnesium : Potassium Ratio**
• Controls potassium uptake and phosphate flow
• Ideal: 1:1 in ppm
• High Mg blocks K and phosphate; high K blocks Mg and Ca
📉 Fix: Foliar spray potassium sulfate + fulvic acid, apply Mg only if deficient
✅ Balanced Mg:K triggers a surge in phosphorus uptake (due to synergy)

c) **Potassium : Sodium Ratio**
• Ideal: K should be 5–10× higher than Na in ppm
• High sodium affects potassium uptake and soil structure
📌 Monitor salinity closely; if Na is too high relative to K, potassium will struggle

d) **Phosphorus : Sulfur Ratio**
• Two major anions with strong antagonism
• Ideal: 1:1 in ppm
• Too much sulfur → phosphate lockout
• Too much phosphate → sulfur lockout
📉 Fix: Adjust one side of the ratio depending on excess or deficiency

e) **Phosphorus : Zinc Ratio**
• Crucial for enzyme function, energy transfer, Brix levels
• Ideal: 10:1 P:Zn in ppm
• Example: 23 ppm P → need 2.3 ppm Zn
📌 Too much phosphate suppresses zinc, and vice versa

f) **Phosphorus : Boron Ratio (Implied)**
• Boron affects calcium uptake, flowering, and sugar transport
• Needs to be balanced with phosphate for full reproductive performance

📈 **3. Ratios Predict Crop Outcomes**
• Poor Ca:Mg → tight, anaerobic soil = low oxygen, poor structure
• High Mg:K → weak sugar transport, small fruit
• Low P:Zn → poor photosynthesis, stunted growth
• Poor P:S → locked-out nutrients, weak stress response

🧠 Knowing these ratios helps you:
• Save money (avoid waste)
• Improve response to foliar programs
• Prevent long-term structural issues

🧪 **4. Application Strategy Based on Ratios**
• Gypsum = best for displacing Mg or Na in high clay soils (forms MgSO₄ or NaSO₄ → leaches out)
• Lime = best for boosting Ca and displacing Mg in low-pH soils
• Micronised minerals = use in seed rows or banding for direct root zone delivery
• Foliar sprays = bypass soil limitations, correct trace deficiencies, boost Brix quickly

📌 **Key Takeaways**
• Mineral ratios matter more than raw numbers
• A balanced soil is more productive, resilient, and profitable
• Learn to think in ppm, base saturation, and ratios
• Foliar and micronised solutions are your most precise correction tools
• Lime and gypsum are not interchangeable—use based on soil need

🧠 **Bonus: What Happens When You Get It Right**
• Improved root structure and soil breathability
• Higher nutrient density and Brix levels
• Reduced chemical inputs and pest pressure
• Stronger resilience to drought, salinity, and temperature extremes

🎓 **Course Wrap-Up – You Are Now Soil Fluent**
Congratulations! You\'ve completed the four core chapters of the Soil Testing Mastery course. You now understand:
• How to read and interpret your soil test
• How to identify and correct imbalances
• How to calculate input rates
• How to build long-term strategies for fertile, resilient soil

🎯 Remember: soil testing isn\'t just data—it\'s the starting point for smarter, more sustainable farming.',
                'order' => 12
            ],

            // Final Quiz
            [
                'title' => 'Soil Testing Mastery Final Quiz',
                'type' => 'quiz',
                'duration_minutes' => 30,
                'content' => 'Test your knowledge of soil testing principles, mineral ratios, and interpretation techniques. This comprehensive quiz covers all the key concepts from the four chapters of the course.',
                'order' => 13,
                'questions' => [
                    [
                        'question' => 'What does a high TEC value on an acidic soil primarily indicate?',
                        'options' => ['High organic matter', 'High mineral content', 'High hydrogen saturation', 'High salinity'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'If your soil test shows 68% calcium, 12% magnesium, and a pH of 5.2, what is likely missing from the test?',
                        'options' => ['Conductivity reading', 'Sodium levels', 'Hydrogen measurement', 'Paramagnetism rating'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'In a sandy soil with a CEC of 5, which calcium to magnesium ratio is most appropriate?',
                        'options' => ['2:1', '3:1', '6:1', '7:1'],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Which mineral interaction is most responsible for phosphate suppression in a high-potassium soil?',
                        'options' => ['Magnesium', 'Calcium', 'Sodium', 'Potassium'],
                        'correct' => 3
                    ],
                    [
                        'question' => 'Which of the following nutrients is not held on the cation exchange sites of the soil colloid?',
                        'options' => ['Calcium', 'Nitrate', 'Magnesium', 'Potassium'],
                        'correct' => 1
                    ],
                    [
                        'question' => 'What is the ideal phosphorus-to-zinc ratio in parts per million?',
                        'options' => ['2:1', '5:1', '10:1', '1:1'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Which form of calcium application is most appropriate when you need to reduce high magnesium levels and avoid pH increase?',
                        'options' => ['Dolomite', 'Lime', 'Gypsum', 'Soft rock phosphate'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'A conductivity reading of 0.1 EC in vegetative crops indicates:',
                        'options' => ['Ideal mineral levels', 'Excess sodium', 'Deficient nutrient availability', 'High salinity risk'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'What is the ideal soil pH for optimal nutrient uptake and microbial activity?',
                        'options' => ['7.0', '5.5', '6.4', '6.8'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Which mineral is most antagonistic to boron when in excess?',
                        'options' => ['Copper', 'Zinc', 'Calcium', 'Iron'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Paramagnetic materials enhance fertility by:',
                        'options' => ['Lowering pH', 'Stimulating microbial nitrogen fixation', 'Attracting atmospheric radio waves and converting them to biophotons', 'Feeding beneficial fungi'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'A ratio of 1200 ppm magnesium to 100 ppm potassium suggests which is most urgent?',
                        'options' => ['Add calcium', 'Apply manganese', 'Foliar spray potassium', 'Apply magnesium sulfate'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'What is the ideal base saturation percentage for potassium in a fruit crop?',
                        'options' => ['1–2%', '3–5%', '6–8%', '10–12%'],
                        'correct' => 1
                    ],
                    [
                        'question' => 'If zinc is deficient and phosphorus is excessive, what effect may occur?',
                        'options' => ['Improved sugar transport', 'Increased calcium availability', 'Suppressed zinc uptake', 'Reduced potassium mobility'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'What is the effect of magnesium on soil nitrogen efficiency in high Mg soils?',
                        'options' => ['Improves nitrogen cycling', 'Inhibits nitrogen fixation and availability', 'Binds with nitrogen and holds it longer', 'Converts nitrate to ammonium'],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Why might high sulfur suppress phosphorus availability?',
                        'options' => ['Both are anions and compete for uptake', 'Sulfur forms insoluble salts with phosphorus', 'Sulfur lowers soil pH', 'Sulfur kills phosphate-solubilising microbes'],
                        'correct' => 0
                    ],
                    [
                        'question' => 'If TEC is not measured, what mistake are farmers likely to make?',
                        'options' => ['Underestimating potassium needs', 'Overestimating sodium saturation', 'Assuming ideal base saturation in acidic soils', 'Applying too much phosphorus'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Which of the following strategies would not increase humus levels in the soil?',
                        'options' => ['Compost application', 'Cover cropping', 'Synthetic nitrogen fertiliser', 'Biological stimulants'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'What is the ideal base saturation for calcium in medium soils?',
                        'options' => ['50-60%', '68-70%', '80-85%', '90-95%'],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Which mineral is most responsible for driving conductivity in the soil?',
                        'options' => ['Calcium', 'Magnesium', 'Potassium', 'Sodium'],
                        'correct' => 2
                    ],
                    [
                        'question' => 'What is the primary benefit of foliar nutrition?',
                        'options' => ['It\'s cheaper than soil application', 'It bypasses soil pH and antagonism problems', 'It lasts longer in the plant', 'It requires less equipment'],
                        'correct' => 1
                    ]
                ]
            ]
        ];

        foreach ($lessons as $lessonData) {
            $questions = null;
            if (isset($lessonData['questions'])) {
                $questions = $lessonData['questions'];
                unset($lessonData['questions']);
            }
            
            $lesson = $course->lessons()->create($lessonData);
            
            if ($questions) {
                foreach ($questions as $questionData) {
                    $lesson->quizQuestions()->create([
                        'question' => $questionData['question'],
                        'options' => $questionData['options'],
                        'correct_answer' => $questionData['correct'],
                        'order' => array_search($questionData, $questions) + 1
                    ]);
                }
            }
        }
    }
}
